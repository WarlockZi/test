<?php


namespace app\core;


use app\controller\Controller;
use app\view\layouts\AdminLayout;
use app\view\layouts\UserLayout;

class Route
{
    protected string $url;
    protected string $uri;
    protected string $namespace;
    protected string $controller = '';
    protected string $baseController = Controller::class;
    protected string $action = 'index';

    protected string $layout;
    protected string $view;
    protected bool $admin;

    protected string $slug = '';
    protected string $id = "0";

    protected array $params;
    protected array $redirect = [];


    protected string $host = '';
    protected string $protocol = '';
    protected bool $notFound = true;
    protected array $errors = [];

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->setUrl();
        $this->setAdmin();
        $this->setLayout();
        $this->setNamespace();
    }

    public function getRedirect(): array
    {
        return $this->redirect;
    }

    public function setRedirect(array $redirect): void
    {
        $this->redirect = $redirect;
    }

    public function getUrL(): string
    {
        return $this->url;
    }

    protected function setUrl(): void
    {
        $arr = explode('?', $this->uri);
        if (isset($arr[1])) {
            $this->setParams($arr[1]);
        }
        $url = $arr[0];
        if (!$url || strpos($url, '=')) return;
        $this->uri = trim($url, '/');
        $this->url = '/' . trim($url, '/');
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getView(): string
    {
        return $this->view ?? $this->action ?? 'index';
    }

    public function setView(string $view): void
    {
        $this->view = $view;
    }

    public function setActionName(string $action): void
    {
        $this->actionName = $action ? $action : 'action' . ucfirst($this->action);
    }

    public function setParams(string $params): void
    {
        if (!$params) return;
        $arr    = explode('&', $params);
        $params = [];
        foreach ($arr as $string) {
            $a             = explode('=', $string);
            $params[$a[0]] = $a[1];
        }
        $this->params = $params;
    }

    public function setError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getAction(): string
    {
        return 'action' . ucfirst($this->action);
    }

    public function setAction(Route $route): void
    {
        $this->actionName = 'action' . ucfirst($route->action);
    }

    public function getActionName(): string
    {
        return $this->action;
    }

    public function isHome(): bool
    {
        return $this->uri === '/';
    }

    public function isNotFound(): bool
    {
        return $this->notFound;
    }

    public function setNotFound(): void
    {
        $this->notFound = false;
    }

    public function getBaseController(): string
    {
        return $this->baseController;
    }

    public function getLayout(): string
    {
        return Auth::userIsAdmin() || Auth::userIsEmployee() ? $this->layout : 'app\view\layouts\UserLayout';
    }

    public function setLayout(): void
    {
        $this->layout = ($this->admin && Auth::getUser())
            ? AdminLayout::class
            : UserLayout::class;
    }

    public function getController(): string
    {
        return $this->controller ? $this->getNamespace() . $this->getControllerFullName() : Controller::class;
    }

    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    public function getNamespace(): string
    {
        return $this->isAdmin() ? "{$this->namespace}" : $this->namespace;
    }

    public function setNamespace(): void
    {
        if ($this->isAdmin()) {
            $this->namespace = 'app\controller\Admin\\';
        } else {
            $this->namespace = 'app\controller\\';
        }
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(): void
    {
        $this->admin = str_contains($this->uri, 'adminsc');
    }

    public function getControllerFullName(): string
    {
        return ucfirst($this->controller) . 'Controller';
    }

    public function getControllerName(): string
    {
        return $this->controller;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsHtml(): string
    {
        $str = '';
        foreach ($this->errors as $error) {
            $str .= "<p class='error'>$error</p>";
        }
        return $str;
    }

    public function __get($name)
    {
        return (property_exists($this, $name)) ? $this->$name : '';
    }

    public function __set($name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function setHost()
    {
        $this->host = $_SERVER['HTTP_HOST'];
    }
//    public function setSlug(string $slug): void
//    {
//        $this->slug = $slug;
//    }
//
//    public function setId(string $id): void
//    {
//        $this->id = $id;
//    }

//
//    public function setProtocol()
//    {
//        $this->protocol = $_SERVER['REQUEST_SCHEME'];
//    }
//    public function setControllerName(string $controllerName): void
//    {
//        $this->controllerName = $controllerName;
//    }
//    public function setController(): void
//    {
//        $this->setNamespace();
//        $this->controllerName = ucfirst($this->controller);
//        $this->controller     = $this->namespace . $this->controllerName . 'Controller';
//    }

}