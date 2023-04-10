<?php


namespace app\core;


class Route
{
	protected $admin;
	protected $controller;
	protected $action = 'index';
	protected $slug;
	protected $id;

	public function __set($name, $value)
	{
		if (property_exists($this, $name)) {
			$this->$$name = $value;
		}
	}

	public function __get($name)
	{
		if (property_exists($this, $name)) {
			return $this->$name;
		}
	}

	public function isAdmin(): bool
	{
		return (bool)$this->admin;
	}

	public function isHome()
	{
		return $this->controller === 'Main' && $this->action === 'index';
	}

	public function getNamespace(Route $route): string
	{
		if ($route->admin) {
			return 'app\controller\Admin\\';
		} else {
			return 'app\controller\\';
		}
	}

	public function setController(Route $route):void
	{
		if ($route->controller){
			$namespace = $this->getNamespace($route);
			$name = ucfirst($route->controller);
			$this->controller = $namespace . $name . 'Controller';
		}else{
			$namespace = $this->getNamespace($route);
			$this->controller = $namespace . 'NotFoundController';
		}
	}
	public function setAmin(Route $route):void
	{
		$route->admin = (bool)$route->admin;
	}

	public function setAction(Route $route):void
	{
		$this->action = 'action' . $this->upperCamelCase($route->action);
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