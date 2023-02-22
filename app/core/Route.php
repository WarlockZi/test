<?php


namespace app\core;


class Route
{
	protected static $admin;
	protected static $controller;
	protected static $action = 'index';
	protected static $slug;
	protected static $id;

	public function __set($name, $value)
	{
		if (property_exists($this, $name)) {
			self::$$name = $value;
		}
	}
	public function __get($name)
	{
		if (property_exists($this, $name)){
			return self::$$name;
		}
	}

	public function isAdmin():bool {
		return (bool) $this->admin;
	}

	public function isHome()
	{
		return $this->controller === 'Main' && $this->action === 'index';
	}
	public function toArray(){
		$f = get_object_vars($this);
//		foreach ($this-> as $item) {
//
//		}
	}
}