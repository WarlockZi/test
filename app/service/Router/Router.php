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

    public function __construct(protected ErrorLogger $errorLogger)
    {

    }

    protected function matchRoute(IRequest $request): void
    {
        $routes = APP->get(IRouteList::class)->getRoutes();

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
    public function dispatch(IRequest $request): void
    {
        $this->matchRoute($request);
        $controller = $request->getController();
//        var_dump('class exists --  ' . class_exists($controller) . PHP_EOL);
//        var_dump("class name --  {$controller}" . PHP_EOL);
//        exit();
//        $exists = class_exists($controller);
//        error_log($controller);

        if (!class_exists($controller)) throw new NoControllerException('Bad controller');

        $controller = APP->get($controller);

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
                return APP->call([APP->make($controller::class), $action]);
            }
        );

        $handler($request);
    }
}