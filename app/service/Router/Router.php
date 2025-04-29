<?php
declare(strict_types=1);

namespace app\service\Router;

use app\exception\NoControllerException;
use app\exception\NoMethodException;
use app\service\Logger\ErrorLogger;

class Router
{
    protected Request $route;
    protected array $routes;
    protected string $namespace;
    protected ErrorLogger $errorLogger;

    public function __construct(ErrorLogger $errorLogger)
    {
        $this->errorLogger = $errorLogger;

    }

    protected function matchRoute(IRequest $request): void
    {
        $routes = APP->get(IRouteList::class)->getRoutes();

        foreach ($routes as $pattern => $r) {
            if (preg_match("#$pattern#i", $request->getUrl(), $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_numeric($k)) {
                        unset($matches[$k]);
                    }
                }
                $matches = array_merge($matches, $r);
                foreach ($matches as $k => $v) {
                    $request->$k = is_string($v) ? strtolower($v) : $v;
                }
                break;
            }
        }
    }

    /**
     * @throws NoControllerException
     * @throws NoMethodException
     */
    public function dispatch(IRequest $request): void
    {
        $this->matchRoute($request);
        $controller = $request->getController();
        if (!class_exists($controller)) throw new NoControllerException('Bad controller');

        $controller = APP->get($controller);

        $action = $request->getAction();
        if (!method_exists($controller, $action)) throw new NoMethodException('Bad action');

        $this->middlwares($request, $controller, $action);
    }

    private function middlwares(IRequest $request, $controller, $action): void
    {
        $handler = array_reduce(
            array_reverse($request->getMiddlewares()),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return (new $middleware())->handle($request, $next);
                };
            },
            function ($request) use ($controller, $action) {
                return $controller->{$action}($request);
            }
        );

        $handler($request);
    }


}

