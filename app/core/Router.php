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
		return self::$namespace . self::$controller;
	}

	public static function setController(): string
	{
		self::setNamespace();
		self::$controller = self::$namespace.self::$route['controller'] . 'Controller';
		return self::$controller;
	}


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
		return (isset(self::$route['admin']) && self::$route['admin'] === 'adminsc');
	}


	public static function dispatch($url)
	{
		$url = self::removeQuryString($url);
		self::matchRoute($url);

		$user = Auth::autorize();
		if (Router::isAdmin() && User::can($user,['role_employee'])) {
			$view = new AdminView(self::$route);
		} else {
			$view = new UserView(self::$route);
		}

		if (!self::$route) NotFound::url($url, $view);

		$controller = self::setController();
		if (!class_exists($controller)) NotFound::controller(self::$controller, $view);
		$controller = new $controller(self::$route);

		$action = 'action' . self::upperCamelCase(self::$route['action']);
		if (!method_exists($controller, $action)) NotFound::action($action, $controller, $view);
		$controller->user = $user;
		$controller->$action();
		$view->view=$controller->view;
		$view->render($controller->vars);

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
