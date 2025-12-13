<?php
declare(strict_types=1);

namespace app\service\Router;

use app\exception\NoControllerException;
use app\exception\NoMethodException;
use app\repository\RouterRepository;

class Router
{
    public function __construct(
        protected IRequest $request,
        protected array    $routes = [],
        protected string   $namespace = '',
    )
    {
    }

    protected function matchRoute(IRequest $request): void
    {
        $routes = RouterRepository::getRoutes();

        foreach ($routes as $route) {

            if (preg_match("#$route[0]#i", $request->path(), $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_numeric($k)) {
                        unset($matches[$k]);
                    }
                }
                $matches = array_merge($matches, $route[1] ?? []);
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
        error_log(PHP_EOL . " **** REFERRER ****: " . $_SERVER['HTTP_REFERER']??'' . PHP_EOL);
        error_log(PHP_EOL . " **** REQUEST_URI ****: " . $_SERVER['REQUEST_URI']??'' . PHP_EOL);
        if (!class_exists($controller)) throw new NoControllerException('Bad controller ' . $controller);

        $action = $request->action();
        if (!method_exists($controller, $action)) throw new NoMethodException('Bad action ' . $action);

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