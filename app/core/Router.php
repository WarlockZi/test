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
        require_once ROOT . '/app/core/routes.php';
        $this->matchRoute();
        $this->errorLogger = new ErrorLogger();
    }

    protected function matchRoute(): void
    {
        $this->route = new Route();
        foreach ($this->routes as $pattern => $r) {
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

    public function dispatch(): void
    {
        Auth::authorize($this->route);

        $controller = $this->route->getController();
        try {
            $controller = new $controller();
        } catch (\Throwable $exception) {
            $this->handleError($exception);
            $controller = $this->route->getBaseController();
            $controller = new $controller;
        }
        $controller->setRoute($this->route);

        $action = $this->route->getAction();
        try {
            $controller->$action();
        } catch (\Throwable $exception) {
            $this->handleError($exception);
        }
        $this->route->setView($this->route->getActionName());
        $layout = $this->route->getLayout();
        $layout = new $layout($this->route, $controller);
        $layout->render();
    }

    private function handleError($exception): void
    {
        if (DEV) {
            echo '<pre>' . $exception->getMessage() . '</pre>';
            echo '<pre>' . $exception->getTraceAsString() . '</pre>';
        }
        $this->errorLogger->write('router error -' . PHP_EOL
            . $exception->getMessage() . PHP_EOL);
    }

    public function add($regexp, $route = []): void
    {
        $this->routes[$regexp] = $route;
    }


}

