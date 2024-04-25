<?php

namespace app\core;

use app\view\layouts\AdminLayout;
use app\view\layouts\UserLayout;

class Router
{
    protected Route $route;
    protected array $routes;
    protected string $namespace;

    public function __construct(string $uri = '')
    {
        $this->fillRoutes();
        $this->matchRoute($uri);
    }

    protected function matchRoute($url)
    {
        $this->route = new Route();
        foreach ($this->routes as $pattern => $r) {
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_numeric($k)) {
                        unset($matches[$k]);
                    }
                }
                $matches = array_merge($matches, $r);
                foreach ($matches as $k => $v) {
                    $this->route->$k = strtolower($v);
                }
                $this->route->setNotFound();
            }
        }
    }

    protected function handleErrors(Route $route)
    {
        if (!class_exists($route->controller)) {
            NotFound::controller($route);
        }
        if (!method_exists($route->controller, $route->actionName)) {
            NotFound::action($route);
        }
    }


    public function dispatch()
    {
        $controller = $this->route->getController();
        $controller = new $controller();

//        Auth::autorize();

        $layout     = $this->route->getLayout();
        $actionName = $this->route->getActionName();
        $action     = $this->route->getAction();
        $this->route->setView($actionName);
        $controller->$action($this->route, $layout);

        $layout = new $layout($this->route, $controller->vars);
        echo $layout->render();

    }

    public static function needsNoAuth()
    {
        return AuthValidator::check(Router::getRoute());
    }

    public function add($regexp, $route = [])
    {
        $this->routes[$regexp] = $route;
    }

    public function fillRoutes(): void
    {
        require_once ROOT . '/app/core/routes.php';
    }
}

