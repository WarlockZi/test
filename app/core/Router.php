<?php

namespace app\core;

use app\Services\Logger\ErrorLogger;

class Router
{
    protected Route $route;
    protected array $routes;
    protected string $namespace;
    protected ErrorLogger $errorLogger;

    public function __construct(string $uri = '')
    {
        $this->fillRoutes();
        $this->matchRoute($uri);
        $this->errorLogger = new ErrorLogger();
    }

    protected function matchRoute($url)
    {
        $this->route = new Route();
        foreach ($this->routes as $pattern => $r) {
            if (preg_match("#$pattern#i", $this->route->url, $matches)) {

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
                break;
            }
        }
        $this->route->isNotFound() ? $this->route->setActionName('default') : $f = 1;
    }

    public function dispatch()
    {
        $controller = $this->route->getController();
        try {
            $controller = new $controller();
        } catch (\Throwable $exception) {
            $controller = $this->route->getBaseController();
            $controller = new $controller;
        }
        $controller->setRoute($this->route);

        $actionName = $this->route->getActionName();
        $action     = $this->route->getAction();
        $this->route->setView($actionName);
        try {
            $controller->$action();
        } catch (\Throwable $exception) {
            $this->errorLogger->write('Router 55 - error in action' . $action . PHP_EOL
                . $exception->getMessage());
        }
        Auth::autorize($this->route);

        $layout = $this->route->getLayout();
        $layout = new $layout($this->route, $controller);
        $layout->render();
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

