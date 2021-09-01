<?php

namespace app\core;

use app\model\User;
use app\controller\СatalogController;
use app\model\Category;

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
// если это категория
		if ($url && $category = App::$app->category->isCategory($url)) {
			$route['controller'] = 'Catalog';
			$route['action'] = 'category';

			self::$route = $route;
			self::$aCategoryOrProduct = $category;
			return true;

// это продукт
		} elseif ($url && $product = App::$app->product->isProduct($url)) {

			$route['controller'] = 'Catalog';
			$route['action'] = 'product';

			self::$route = $route;
			self::$aCategoryOrProduct = $product;
			return true;

// это страница не продукт и не категория
		} else {

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
		return false;
	}

	public static function dispatch($url)
	{
		require_once ROOT . '/app/core/routes.php';

		$url = self::removeQuryString($url);
		if (self::matchRoute($url)) {

			$controller = 'app\controller\\' . self::$route['controller'] . 'Controller';
			if (class_exists($controller)) {
				$cObj = new $controller(self::$route);
				$action = 'action' . self::upperCamelCase(self::$route['action']); // . 'Action'; //Action для того, чтобы пользователь не мог обращаться к функции(хотя можно написать protected)
				if (method_exists($cObj, $action)) {
					$cObj->$action(self::$aCategoryOrProduct); // Выполним метод
					$cObj->getView(); // Подключим вид
				} else {
					echo "<br><b>$action</b> не найден...  ";
				}
			} else {
				echo "<br>Класс <b>$controller</b> не найден";
			}

		} else {
			http_response_code(404);
			include ROOT . '/public/404.html';
		}
	}

	public static function getRoutes()
	{
		return self::$routes;
	}

	public static function getRoute()
	{
		return self::$route;
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

			if (strpos($params[0], '=') === FALSE) {

				return trim(str_replace("XDEBUG_SESSION_START=netbeans-xdebug", "", $params[0]), '/');
			} else {
				return '';
			}
		}
	}
}
