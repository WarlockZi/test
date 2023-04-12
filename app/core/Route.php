<?php


namespace app\core;


class Route
{
	protected $namespace;
	protected $controller;
	protected $controllerName;
	protected $action = 'index';
	protected $actionName = 'index';

	protected $admin;
	protected $slug;
	protected $id;
	protected $url;
	protected $extra;
	protected $handler;

	protected $uri;
	protected $params;

	public function __construct()
	{
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

	public function setParams($params){
		$this->params = $params;
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
		if ($route->controller) {
			$this->setNamespace($route);
//			$this->namespace = $this->getNamespace($route);
			$this->controllerName = ucfirst($route->controller);
			$this->controller = $this->namespace . $this->controllerName . 'Controller';
		} else {
			$this->setNamespace($route);
			$namespace = $this->getNamespace($route);
			$this->controller = $namespace . 'NotFoundController';
		}
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
		$this->actionName = 'action' . $this->upperCamelCase($route->action);
	}

	protected function upperCamelCase($name): string
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
	}

	protected function lowerCamelCase($name)
	{
		return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $name))));
	}
}