<?php
declare(strict_types=1);

namespace app\service\Router;

use app\exception\NoControllerException;
use app\exception\NoMethodException;
use app\service\Logger\ErrorLogger;

class Router
{
    public function __construct(
        protected ErrorLogger $errorLogger,
        protected IRequest    $request,
        protected array       $routes = [],
        protected string      $namespace = '',
    )
    {
    }

    protected function matchRoute(IRequest $request): void
    {
        $rl     = APP->get(IRouteList::class);
        $routes = $rl->getRoutes();

        foreach ($routes as $pattern => $r) {
            if (preg_match("#$pattern#i", $request->getPath(), $matches)) {

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
    public function dispatch(): void
    {
        $request = $this->request;
        $this->matchRoute($request);
        $controller = $request->getController();
        if (!class_exists($controller)) throw new NoControllerException('Bad controller');

        $action = $request->getAction();
        if (!method_exists($controller, $action)) throw new NoMethodException('Bad action');

        $this->middlwares($request, $controller, $action);
    }

    private function middlwares($request, $controller, $action): void
    {
        $handler = array_reduce(
            array_reverse($request->getMiddlewares()),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return (new $middleware())->handle($request, $next);
                };
            },
            function () use ($controller, $action) {
                return APP->call([APP->get($controller), $action]);
            }
        );

        $handler($request);
    }
}