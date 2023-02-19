<?php

namespace app\core;

use app\model\User;
use app\view\AdminView;
use app\view\UserView;

class Router
{
	protected static $routes = [];
	protected static $route = [];
	protected static $namespace;
	protected static $controller;


	public static function setNamespace(): void
	{
		if (isset(self::$route['admin']) && self::$route['admin']) {
			self::$namespace = 'app\controller\Admin\\';
		} else {
			self::$namespace = 'app\controller\\';
		}
	}

	public static function setController(): string
	{
		self::setNamespace();
		self::$controller = self::$namespace . self::$route['controller'] . 'Controller';
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
		$route = [
			'admin' => '',
			'controller' => 'Adminsc',
			'action' => 'index',
			'slug' => '',
			'id' => 0
		];

		foreach (self::$routes as $pattern => $r) {
			if (preg_match("#$pattern#i", $url, $matches)) {

				foreach ($matches as $k => $v) {
					if (is_numeric($k)) {
						unset($matches[$k]);
					}
				}

				$r = array_merge($matches,$r);
				foreach ($route as $k => $v) {
					if (isset($r[$k])) {
						$route[$k] = $r[$k];
					}
				}
				$route['controller'] = self::upperCamelCase($route['controller']);;
				self::$route = $route;
			}
		}
	}

	public static function isAdmin()
	{
		return self::$route['admin'];
	}

	public static function dispatch($url)
	{
		Router::matchRoute($url);

		if (!self::$route) NotFound::url($url);

		$controller = self::setController();
		if (!class_exists($controller)) NotFound::controller(self::$controller);
		$controller = new $controller(self::$route);

		$action = 'action' . self::upperCamelCase(self::$route['action']);
		if (!method_exists($controller, $action)) NotFound::action($action, $controller);
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

	public static function isLogin(array $route)
	{
		return $route['controller'] === 'Auth' && $route['action'] === 'login';
	}

	public static function isHome()
	{
		$route = Router::getRoute();
		return $route['controller'] === 'Main' && $route['action'] === 'index';
	}


	public static function getRoute(): array
	{
		return self::$route;
	}
}
