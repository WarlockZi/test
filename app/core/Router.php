<?php

namespace app\core;

class Router
{
	protected static $routes = [];
	protected static $route;
	protected $namespace;
	protected $controller;

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
		$route->setUrl($url);
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
		$parcedRoute = $this->matchRoute($url);

		$parcedRoute->setAmin($parcedRoute);
		$parcedRoute->setController($parcedRoute);
		$parcedRoute->setAction($parcedRoute);

		self::$route = $parcedRoute;

		Router::handleErrors($parcedRoute);

		$controller = new self::$route->controller;

		Auth::autorize();
		$action = self::$route->actionName;
		$controller->$action();

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
			$route->controllerName === 'Auth' && $route->action === 'login'
			|| $route->controllerName === 'Auth' && $route->action === 'register'
			|| $route->controllerName === 'Auth' && $route->action === 'returnpass'
			|| $route->controllerName === 'Auth' && $route->action === 'noconfirm'
			|| $route->controllerName === 'main' && $route->action === 'index'
			|| $route->controllerName === 'product' && !$route->admin
			|| $route->controllerName === 'category' && !$route->admin;
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
