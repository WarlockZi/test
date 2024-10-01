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
                    $this->route->$k = is_string($v)?strtolower($v):$v;
                }

                $this->redirect();
                $this->route->setNotFound();
                break;
            }
        }
        $this->route->isNotFound() ? $this->route->setActionName('default') : $f = 1;
    }
    private function redirect():void
    {
        if (!$this->route->redirect) return;
        $arr = $this->route->getRedirect();
        $from = key($arr);
        $to = $arr[$from];
        $url = $this->route->getUrL();
        $newUrl = str_replace($from,$to,$url);

//        header("HTTP/2 301 Moved Permanently");
//        header("Location: https://{$this->route->getHost()}".$newUrl);
        header("Location: https://{$this->route->getHost()}".$newUrl, true, 301);
        exit();

    }

    public function dispatch(): void
    {
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
        $this->route->setView($this->route->getActionName());
        try {
            $controller->$action();
        } catch (\Throwable $exception) {
            $this->handleError($exception);
        }
        if ($controller->isAjax()) exit;
        Auth::authorize($this->route);

        $layout = $this->route->getLayout();
        $layout = new $layout($this->route, $controller);
        $layout->render();
    }

    private function handleError($exception): void
    {
        if ($_ENV['DEV'] == 1) {
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


    public function fillRoutes(): void
    {
        require_once ROOT . '/app/core/routes.php';
    }


}

