<?php


namespace app\core;


use app\controller\NotFoundController;
use mysql_xdevapi\Exception;

class Route
{
	protected $namespace;
	public $controller= 'NotFound';
	public $controllerName = NotFoundController::class;
	public $action = 'index';
	public $actionName = 'actionIndex';

	protected $admin;
	protected $slug;
	protected $id;
	protected $url;
	protected $extra;
	protected $handler;

	protected $uri;
	protected $params;
	protected $host;
	protected $protocol;

	public function setParams($params){
		$this->params = $params;
	}

	public function setHost(){
		$this->host = $_SERVER['HTTP_HOST'];
	}
	public function setProtocol(){
		$this->protocol = $_SERVER['REQUEST_SCHEME'];
	}
	public function setUri($uri){
		$this->uri = $uri;
	}

	public function isAdmin(): bool
	{
		return (bool)$this->admin;
	}

	public function isHome()
	{
		return $this->controller === 'Main' && $this->action === 'index';
	}

	public function getNamespace(): string
	{
		return $this->namespace;
	}

	public function setNamespace(Route $route)
	{
		if ($route->admin) {
			$this->namespace = 'app\controller\Admin\\';
		} else {
			$this->namespace = 'app\controller\\';
		}
	}

	public function setController(Route $route): void
	{
			$this->setNamespace($route);
			$this->controllerName = ucfirst($route->controller);
			$this->controller = $this->namespace . $this->controllerName ;
	}
	public function getController(): string
	{
		if (!class_exists($this->controller))
			throw new \Exception("Класс {$this->controller} не существует");
		return $this->controller;
	}

	public function getAction(): string
	{
		if (!method_exists($this->action,$this->controller))
			throw new \Exception("Метод {$this->action} не существует");
		return $this->action;
	}

	public function getActionName(): string
	{
		return $this->actionName;
	}

	public function setAmin(Route $route): void
	{
		$this->admin = (bool)$route->admin;
	}
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}

	public function setAction(Route $route): void
	{
//		$this->actionName = 'action' . $this->upperCamelCase($route->action);
	}

	protected function upperCamelCase($name): string
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
	}

	protected function lowerCamelCase($name)
	{
		return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $name))));
	}

	public function getControllerName()
	{
		return $this->controllerName;
	}
}