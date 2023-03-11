<?php

namespace app\core;

use app\controller\Controller;

class Router
{
	protected static $routes = [];
	protected static $namespace;
	protected static $controller;

	protected static $route;

	public static function setNamespace(): void
	{
		if (self::$route->admin) {
			self::$namespace = 'app\controller\Admin\\';
		} else {
			self::$namespace = 'app\controller\\';
		}
	}

	public static function setController(): string
	{
		self::setNamespace();
		self::$controller = self::$namespace . self::$route->controller . 'Controller';
		return self::$controller;
	}

	public static function add($regexp, $route = [])
	{
		self::$routes[$regexp] = $route;
	}

	public static function fillRoutes(): void
	{
		require_once ROOT . '/app/core/routes.php';
	}

	public static function matchRoute($url): void
	{
		foreach (self::$routes as $pattern => $r) {
			if (preg_match("#$pattern#i", $url, $matches)) {

				foreach ($matches as $k => $v) {
					if (is_numeric($k)) {
						unset($matches[$k]);
					}
				}

				$matches = array_merge($matches,$r);
				$route = new Route();
				foreach ($matches as $k => $v) {
					$route->$k = strtolower($v);
				}
				self::$route = $route;
			}
		}

	}

	protected static function handleErrors(string $controller, string $action)
	{
		if (!class_exists($controller)){
			NotFound::controller($controller);
		}else if (!Router::$route->action){
			NotFound::action($controller);
		}

	}

	public static function dispatch($url)
	{
		Router::matchRoute($url);

		$controller = self::setController();
		$action = 'action' . self::upperCamelCase(self::$route->action);

		Router::handleErrors($controller, $action);

		$controller = new $controller;
		Auth::autorize();
		$controller->$action();

		$controller->setView();
	}

	protected static function upperCamelCase($name): string
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
	}

	protected static function lowerCamelCase($name)
	{
		return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $name))));
	}

	public static function removeQuryString(string $url)
	{
		$params = explode('&', $url, 2);
		if (!$url || strpos($params[0], '=')) return '';
		return trim($params[0], '/');
	}

	public static function needsNoAuth()
	{
		$route = Router::getRoute();
		return
      $route->controller === 'auth' && $route->action === 'login'
			|| $route->controller === 'auth' && $route->action === 'noconfirm'
			|| $route->controller === 'main' && $route->action === 'index'
			|| $route->controller === 'product'
			|| $route->controller === 'category';
	}

	public static function getRoute(): Route
	{
		return self::$route;
	}
}
