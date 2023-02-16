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
		foreach (self::$routes as $pattern => $route) {
			if (preg_match("#$pattern#i", $url, $matches)) {
				$route = [
					'admin' => '',
					'controller' => '',
					'action' => 'index',
					'slug' => '',
					'id' => 0];

				foreach ($matches as $k => $v) {
					if (is_string($k)) {
						$route[$k] = $v;
					}
				}
				if ($route['admin'] && !$route['controller']) {
					$route['controller'] = 'Adminsc';
				}
				if ($route['action'] ==='index' && !$route['controller']) {
					$route['controller'] = 'Main';
				}

				$controller = isset($route['controller']) ? self::upperCamelCase($route['controller']) : '';
				$route['controller'] = $controller;

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

		if (Router::isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
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
		$controller->$action();

		$view->view = $controller->view;
		$view->render($controller->vars);

//		$controller->getView();
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
		if (!isset($route['controller'])) return false;
		if (!isset($route['action'])) return false;
		return $route['controller'] === 'Auth' && $route['action'] === 'login';
	}

	public static function isHome()
	{
		$route = Router::getRoute();
		if (!isset($route['controller'])) return false;
		if (!isset($route['action'])) return false;
		return $route['controller'] === 'Main' && $route['action'] === 'index';
	}


	public static function getRoute(): array
	{
		return self::$route;
	}
}
