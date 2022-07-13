<?php

namespace app\core;

use app\controller\СatalogController;

class Router
{

	protected static $routes = [];
	protected static $route = [];
	protected static $aCategoryOrProduct = [];

	public static function add($regexp, $route = [])
	{
		self::$routes[$regexp] = $route;
	}

	public static function matchRoute($url)
	{
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
				return true;
			}
		}
	}

	public static function dispatch($url)
	{
		require_once ROOT . '/app/core/routes.php';

		$url = self::removeQuryString($url);
		if (self::matchRoute($url)) {

			$controller = 'app\controller\\' . self::$route['controller'] . 'Controller';

			if (class_exists($controller)) {
				$controller = new $controller(self::$route);
				$action = 'action' . self::upperCamelCase(self::$route['action']); // . 'Action'; //Action для того, чтобы пользователь не мог обращаться к функции(хотя можно написать protected)
				if (method_exists($controller, $action)) {
					$controller->$action(self::$aCategoryOrProduct); // Выполним метод
					$controller->getView(); // Подключим вид
				} else {
					http_response_code(404);
					include ROOT . '/public/404.html';
					exit("<br><b>$action</b> не найден...  ");
				}

			} else {
				http_response_code(404);
				include ROOT . '/public/404.html';
				exit("<br>Класс <b>".self::$route['controller']."</b> не найден");
			}
		}
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
}
