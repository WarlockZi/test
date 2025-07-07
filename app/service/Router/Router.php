<?php
declare(strict_types=1);

namespace app\service\Router;

use app\exception\NoControllerException;
use app\exception\NoMethodException;
use app\repository\RouterRepository;
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
        $routes     = RouterRepository::getRoutes();

        foreach ($routes as $route) {

            if (preg_match("#$route[0]#i", $request->path(), $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_numeric($k)) {
                        unset($matches[$k]);
                    }
                }
                $matches = array_merge($matches, $route[1]??[]);
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
        $controller = $request->controller();
        if (!class_exists($controller)) throw new NoControllerException('Bad controller');

        $action = $request->action();
        if (!method_exists($controller, $action)) throw new NoMethodException('Bad action');

        $this->middlwares($request, $controller, $action);
    }

    private function middlwares($request, $controller, $action): void
    {
        $handler = array_reduce(
            array_reverse($request->middlewares()),
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