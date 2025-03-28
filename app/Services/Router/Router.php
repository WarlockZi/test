<?php
declare(strict_types=1);
namespace app\Services\Router;

use app\Services\AuthService\Auth;
use app\Services\Logger\ErrorLogger;
use DI\Container;

class Router
{
    protected Route $route;
    protected array $routes;
    protected string $namespace;
    protected ErrorLogger $errorLogger;

    public function __construct(string $uri = '')
    {
        require_once ROOT . '/app/Services/Router/routes.php';
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

    public function dispatch(Container $container): void
    {

        try {
            Auth::authorize($this->route);
            $controller = $this->route->getController();
            if (!Permitions::isEmployeeOrAdmin($this->route)) {
                header("Location:/");
                exit();
            }
            $controller = $container->get($controller);
            $controller->setRoute($this->route);
            $action = $this->route->getAction();
            method_exists($controller, $action)
                ? $controller->$action()
                : $controller->actionNotFound();
        } catch (\Throwable $exception) {
            $controller = $this->route->getBaseController();
            $this->handleError($exception);
            $controller = new $controller;
        }

        $this->route->setView($this->route->getActionName());
        $layout = $this->route->getLayout($this->route, $controller);
        $layout->render();
    }

    private function handleError(\Throwable $exception): void
    {
        if (DEV) {
            $this->route->setError($exception->getMessage());
            $this->route->setError($exception->getTraceAsString());
        }
        $this->errorLogger->write('router error -' . PHP_EOL
            . $exception->getMessage() . PHP_EOL);
    }

    public function add($regexp, $route = []): void
    {
        $this->routes[$regexp] = $route;
    }


}

