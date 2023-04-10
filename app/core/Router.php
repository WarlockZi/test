<?php

namespace app\core;

use app\controller\Controller;

class Router
{
	protected static $routes = [];
	protected $namespace;
	protected $controller;

	protected static $route;

	public function __construct()
	{
		$this->fillRoutes();
	}

	public static function getRoute()
	{
		return self::$route;
	}

	public function matchRoute($url): Route
	{
		$route = new Route();
		foreach (self::$routes as $pattern => $r) {
			if (preg_match("#$pattern#i", $url, $matches)) {

				foreach ($matches as $k => $v) {
					if (is_numeric($k)) {
						unset($matches[$k]);
					}
				}
				$matches = array_merge($matches, $r);
				foreach ($matches as $k => $v) {
					$route->$k = strtolower($v);
				}
				self::$route = $route;
			}
		}
		return $route;
	}

	protected function handleErrors(Route $route)
	{
		if (!class_exists($route->controller)) {
			NotFound::controller($route);
		} else if (!Router::$route->action) {
			NotFound::action($route);
		}
	}

	public function dispatch($url)
	{
		$route = $this->matchRoute($url);

		$route->setAmin($route);
		$route->setController($route);
		$route->setAction($route);
		$this::$route = $route;

		Router::handleErrors($route);

		$controller = new $this->route->controller;

		Auth::autorize();
		$controller->$this->route->action();

		$controller->setView();
	}


	public function removeQuryString(string $url): string
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
			|| $route->controller === 'auth' && $route->action === 'register'
			|| $route->controller === 'auth' && $route->action === 'noconfirm'
			|| $route->controller === 'main' && $route->action === 'index'
			|| $route->controller === 'product' && !$route->admin
			|| $route->controller === 'category' && !$route->admin;
	}
	public static function add($regexp, $route = [])
	{
		self::$routes[$regexp] = $route;
	}

	public function fillRoutes(): void
	{
		require_once ROOT . '/app/core/routes.php';
	}

}
