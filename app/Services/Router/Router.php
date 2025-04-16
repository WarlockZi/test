<?php
declare(strict_types=1);

namespace app\Services\Router;

use app\Exceptions\NoControllerException;
use app\Exceptions\NoMethodException;
use app\Services\Logger\ErrorLogger;

class Router
{
    protected Route $route;
    protected array $routes;
    protected string $namespace;
    protected ErrorLogger $errorLogger;

    public function __construct(string $uri, ErrorLogger $errorLogger)
    {
        $this->route       = new Route();
        $this->errorLogger = $errorLogger;
        include ROOT . '/app/Services/Router/routes.php';

        $this->matchRoute($this->routes ?? []);
    }

    protected function matchRoute(array $routes): void
    {
        if (empty($routes)) return;

        foreach ($routes as $pattern => $r) {
            if (preg_match("#$pattern#i", $this->route->getUrl(), $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_numeric($k)) {
                        unset($matches[$k]);
                    }
                }

                $matches = array_merge($matches, $r);
                foreach ($matches as $k => $v) {
                    $this->route->$k = is_string($v) ? strtolower($v) : $v;
                }

                $this->route->setNotFound();
                break;
            }
        }
        $this->route->isNotFound() ? $this->route->setActionName('default') : $f = 1;
    }

//    public function dispatch(): void
//    {
//
//        try {
//            Auth::authorize($this->route);
//            $controller = $this->route->getController();
//            if (!Permitions::isEmployeeOrAdmin($this->route)) {
//                header("Location:/");
//                exit();
//            }
//            $controller = APP->get($controller);
//
//            $controller->setRoute($this->route);
//            $action = $this->route->getAction();
//            method_exists($controller, $action)
//                ? $controller->$action()
//                : $controller->actionNotFound();
//        } catch (\Throwable $exception) {
//            $controller = $this->route->getBaseController();
//            $this->handleError($exception);
//            $controller = new $controller;
//        }
//    }

    /**
     * @throws NoControllerException
     */
    public function dispatch($request): void
    {

        $controller = $this->route->getController();

        if (!class_exists($controller)) throw new NoControllerException('Bad controller');
        $controller = APP->get($controller);

        $action = $this->route->getAction();

        if (!method_exists($controller, $action)) throw new NoMethodException('Bad action');

        $this->handleRoute($request, $controller, $action);

    }

    private function handleRoute($request, $controller, $action)
    {
        $handler = array_reduce(
            array_reverse($this->route->getMiddlewares()),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return (new $middleware())->handle($request, $next);
                };
            },
            function ($request) use ($controller, $action) {
                return $controller->{$action}($request);
            }
        );

        return $handler($request);
    }


    public function addRoute(string $regexp, array $route = [], array $middlewares = []): void
    {
        if (!empty($middlewares)) {
            $this->route->setMiddlewares($middlewares);
        }
        $this->routes[$regexp] = $route;
    }

}

