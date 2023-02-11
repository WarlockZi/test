<?php

namespace app\core;

use app\view\AdminView;
use app\view\UserView;

class Router
{
	protected static $routes = [];
	protected static $route = [];
	protected static $namespace;

	public static function getNamespace()
	{
		return self::$namespace;
	}

	public static function setNamespace(): void
	{
		if (isset(self::$route['admin']) && self::$route['admin']) {
			self::$namespace = 'app\controller\admin\\';
		}
		self::$namespace = 'app\controller\\';
	}

	public static function getController()
	{
		return self::$controller;
	}

	public static function setController(): void
	{
		self::$controller = self::$route['controller'] . 'Controller';
	}

	protected static $controller;

	public static function add($regexp, $route = [])
	{
		self::$routes[$regexp] = $route;
	}

	public static function matchRoute($url): void
	{
		require_once ROOT . '/app/core/routes.php';
		foreach (self::$routes as $pattern => $route) {
			if (preg_match("#$pattern#i", $url, $matches)) {
				foreach ($matches as $k => $v) {
					if (is_string($k)) { // превращаем нумеро7ванный массив в ассоциативный
						$route[$k] = $v;
					}
				}
				if (!isset($route['action'])) {
					$route['action'] = 'index';
				}
				$route['controller'] = isset($route['controller']) ? self::upperCamelCase($route['controller']) : '';

				self::$route = $route;
			}
		}
	}

	protected static function isAdmin()
	{
		return (isset(self::$route['controller']) && self::$route['controller'] ==='Adminsc') ;
	}


	public static function dispatch($url)
	{
		$url = self::removeQuryString($url);
		self::matchRoute($url);
		$user = Auth::autorize();
		if (Router::isAdmin()) {
			$view = new AdminView(self::$route);
		} else {
			$view = new UserView(self::$route);
		}

		if (!self::$route) NotFound::url($url);

		self::setNamespace();
		self::setController();
		$controller = self::$namespace . self::$controller;
		if (!class_exists($controller)) NotFound::controller();
		$controller = new $controller(self::$route);

		$action = 'action' . self::upperCamelCase(self::$route['action']);
		if (!method_exists($controller, $action)) NotFound::action($action, $controller, $view);
		$controller->user = $user;
		$controller->$action();
		$view->render();

//		$controller->getView();
	}

	protected static function upperCamelCase($name)
	{
		$name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
		return $name;
	}

	protected static function lowerCamelCase($name)
	{
		$name = str_replace('-', ' ', $name);
		$name = ucwords($name);
		$name = str_replace(' ', '', $name);
		$name = lcfirst($name);
		return $name;
	}

	protected static function removeQuryString($url)
	{
		if ($url) {
			$params = explode('&', $url, 2);
			if (!strpos($params[0], '=')) {
				return trim($params[0], '/');
			} else {
				return '';
			}
		}
	}

	public static function isLogin(array $route)
	{
		return $route['controller'] === 'Auth' && $route['action'] === 'login';
	}


	public static function getRoute(): array
	{
		return self::$route;
	}
}
