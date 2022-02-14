<?php
namespace Engine\DI;

class DI
{
	private $container = [];
	public function set($key, $value){

		$this->container[$key]=$value;
		return $this;

	}

	public function get($key)
	{
		return $this->has($key);
	}

	public function has($key)
	{
		return isset($this->container[$key])? $this->container[$key]:null;
	}


}