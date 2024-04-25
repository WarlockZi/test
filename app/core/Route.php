<?php


namespace app\core;


use app\controller\Controller;
use app\controller\MainController;
use app\view\layouts\AdminLayout;
use app\view\layouts\Layout;
use app\view\layouts\UserLayout;

class Route
{
    protected string $url;
    protected string $uri;
    protected string $namespace;
    protected string $controller;
    protected string $baseController;
    protected string $action;
    protected string $layout;
    protected string $view;
    protected bool $admin;
    protected string $slug;
    protected string $id;
    protected string $extra;
    protected string $params;
    protected string $host;
    protected string $protocol;
    protected bool $notFound;
    protected array $errors;
    private static Route $route;

    public function __construct()
    {
        $this->uri            = $_SERVER['REQUEST_URI'];
        $this->action         = 'index';
        $this->params         = '';
        $this->host           = '';
        $this->protocol       = '';
        $this->notFound       = true;
        $this->baseController = Controller::class;
        $this->controller     = '';

        $this->setAdmin();
        $this->setLayout();
        $this->setNamespace();
    }

    public static function getRoute()
    {
        return new static();
    }
    public function setView(string $view):void
    {
        $this->view = $view;
    }
    public function getView(): string
    {
        return $this->action ?? 'index';
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    protected function setUrl()
    {
        $arr = explode('?', $this->uri);
        if (isset($arr[1])) {
            $this->setParams($arr[1]);
        }
        $url = $arr[0];
        if (!$url || strpos($url, '=')) return '';
        return trim($url, '/');
    }

    public function setAction(Route $route): void
    {
        $this->actionName = 'action' . $this->upperCamelCase($route->action);
    }

    public function setParams(string $arr): void
    {
        if (!$arr) return;
        $arr    = explode('&', $arr);
        $params = [];
        foreach ($arr as $string) {
            $a             = explode('=', $string);
            $params[$a[0]] = $a[1];
        }
        $this->params = $params;
    }

    public function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    public function setAdmin(): void
    {
        $this->admin = $this->uri;
    }

    public function setLayout(): void
    {
        $this->layout = $this->admin ? AdminLayout::class : UserLayout::class;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setExtra(string $extra): void
    {
        $this->extra = $extra;
    }

    public function setNotFound(): void
    {
        $this->notFound = false;
    }

    public function setError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function setHost()
    {
        $this->host = $_SERVER['HTTP_HOST'];
    }

    public function setProtocol()
    {
        $this->protocol = $_SERVER['REQUEST_SCHEME'];
    }

    public function getAction(): string
    {
        return 'action' . ucfirst($this->action);
    }
    public function getActionName(): string
    {
        return $this->action;
    }
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function isHome()
    {
        return $this->uri === '/';
    }

    public function isNotFound()
    {
        return $this->notFound;
    }

    public function setNamespace()
    {
        if ($this->isAdmin()) {
            $this->namespace = 'app\controller\Admin\\';
        } else {
            $this->namespace = 'app\controller\\';
        }
    }

    public function setController(): void
    {
        $this->setNamespace($this);
        $this->controllerName = ucfirst($this->controller);
        $this->controller     = $this->namespace . $this->controllerName . 'Controller';
    }

//


    public function getBaseController(): string
    {
        return $this->baseController;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function getController()
    {
        return $this->controller ? $this->getNamespace() . $this->getControllerFullName() : '';
    }

    public function getControllerFullName(): string
    {
        return ucfirst($this->controller) . 'Controller';
    }

    public function getControllerName(): string
    {
        return $this->controller;
    }

    public function getErrors(): string
    {
        $errors = '';
        foreach ($this->errors as $error) {
            $errors .= $error;
        }
        return $errors;
    }
//    public function setAmin(): void
//    {
//        $this->admin  = str_contains($this->uri, 'adminsc') ? true : false;
//        $this->layout = $this->admin ? new AdminLayout() : new UserLayout();
//        $this->view   = '';
//    }


}