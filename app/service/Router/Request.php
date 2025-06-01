<?php


namespace app\service\Router;


use app\service\AuthService\Auth;
use Illuminate\Support\Str;

class Request implements IRequest
{
    protected string $host;

    protected string $url;
    protected string $path;
    protected array $params = [];

    protected string $method = 'GET';
    protected array $body;
    protected array $files;
    protected array $cookie;

    protected string $controller = '';
    protected string $action = 'index';

    protected string $slug = '';
    protected string $id = "0";
    protected array $middlewares = [];

    public function __construct()
    {
    }

    /**
     * @throws \Exception
     */
    public static function capture(): IRequest
    {
        $self = new self();

        $self->url    = $_SERVER['REQUEST_URI'] ?? '';
        $self->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $self->host   = $_SERVER['HTTP_HOST'];
        $self->body   = $_POST ?? '';
        $self->cookie = $_COOKIE ?? [];
        $self->parseUrl();
        $self->setAjaxRequest();
        $self->setFiles();

        return $self;
    }

    private function parseUrl(): void
    {
        $this->path = parse_url($this->url)['path'];
        $query      = parse_url($this->url)['query'] ?? '';
        parse_str($query, $this->params);
    }

    /**
     * @throws \Exception
     */
    public function setFiles(): void
    {
        if (empty($_FILES['file'])) return;
        $this->files = $_FILES['file'];
    }
    public function files(): array
    {
        return $this->files;
    }
    public function body(): array
    {
        return $this->body;
    }
    public function setAjaxRequest(): void
    {
        if (empty($_POST['params'])) return;
        $req = json_decode($_POST['params'], true) ?? [];
        if (!Auth::validatePphSession($req)) throw new \Exception('плохой ключ сессии');
        if ($this->isAjax()) {
            unset($req['phpSession']);
            $this->body = $req;
        }
    }

    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    public function __set(string $name, array|string $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getUrL(): string
    {
        return $this->url;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getAction(): string
    {
        return 'action' . ucfirst($this->action);
    }

    public function getActionName(): string
    {
        return $this->action;
    }

    public function getController(): string
    {
        return $this->getNamespace() . $this->getControllerFullName();

    }

    public function getNamespace(): string
    {
        return $this->isAdmin()
            ? "app\controller\Admin\\"
            : 'app\controller\\';
    }

    public function isHome(): bool
    {
        return $this->path === '/';
    }

    public function isAdmin(): bool
    {
        return Str::contains($this->url, 'adminsc');
    }


    public function getControllerFullName(): string
    {
        return ucfirst($this->controller) . 'Controller';
    }

    public function getControllerName(): string
    {
        return $this->controller;
    }

    public function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }


}