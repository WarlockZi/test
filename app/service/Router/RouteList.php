<?php

namespace app\service\Router;

use app\service\Cache\Redis\Cache;

class RouteList implements IRouteList
{

    protected array $routes = [];
    protected array $route;

    public function __construct()
    {
        Cache::remember('routes', function () {
            include ROOT . '/app/service/Router/routes.php';
        }, 1);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function addRoute(string $regexp, array $route = [], array $middlewares = []): void
    {
        $this->routes[$regexp] = $route;
        if (!empty($middlewares)) {
            $this->routes[$regexp]['middlewares'] = $middlewares;
        }

    }
}