<?php

namespace app\core;

class Router
{
	protected static $routes = [];
	protected static $route;
	protected $namespace;
	protected $controller;
	protected $uri;
	protected $url;
	protected $params;

	public function __construct(string $uri)
	{
		$this->uri = $uri;
		$this->url = $this->getUrl($uri);
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
		}
		if (!method_exists($route->controller,$route->actionName)){
			NotFound::action($route);
		}
	}

	public function dispatch()
	{
		$parcedRoute = $this->matchRoute($this->url);
		$parcedRoute->setUri($this->uri);
		$parcedRoute->setParams($this->params);
		$parcedRoute->setAmin($parcedRoute);
		$parcedRoute->setController($parcedRoute);
		$parcedRoute->setAction($parcedRoute);

		self::$route = $parcedRoute;

		Router::handleErrors($parcedRoute);

		$controller = new self::$route->controller;

		Auth::autorize();
		$action = self::$route->actionName;
		if (!method_exists($controller, $action)){
			http_response_code(404);
			include(ROOT.'/app/view/404/index.php'); // provide your own HTML for the error page
			die();
		}
		$controller->$action();

		$controller->setView();
	}

	protected function getUrl($uri)
	{
		$arr = explode('?', $uri);
		if (isset($arr[1])) {
			$this->getParams($arr[1]);
		}
		$url = $arr[0];
		if (!$url || strpos($url, '=')) return '';
		return trim($url, '/');
	}

	public function getParams(string $arr): void
	{
		if (!$arr) return;
		$arr = explode('&', $arr);
		$params = [];
		foreach ($arr as $string) {
			$a = explode('=', $string);
			$params[$a[0]] = $a[1];
		}
		$this->params = $params;
	}

	public static function needsNoAuth()
	{
		$route = Router::getRoute();
		return
			$route->controllerName === 'Auth' && $route->action === 'login'
			|| $route->controllerName === 'Cart'
			|| $route->controllerName === 'Main'
			|| $route->controllerName === 'Bot'
			|| $route->controllerName === 'Promotion'
			|| $route->controllerName === 'Orderitem'
			|| $route->controllerName === 'Search'

			|| $route->controllerName === 'Sync' && $route->action === 'part'
			|| $route->controllerName === 'Sync' && $route->action === 'init'
			|| $route->controllerName === 'Sync' && $route->action === 'load'

			|| $route->controllerName === 'Auth' && $route->action === 'register'
			|| $route->controllerName === 'Auth' && $route->action === 'returnpass'
			|| $route->controllerName === 'Auth' && $route->action === 'noconfirm'
			|| $route->controllerName === 'Auth' && $route->action === 'confirm'
			|| $route->controllerName === 'Main' && $route->action === 'index'
			|| $route->controllerName === 'Product' && !$route->admin
			|| $route->controllerName === 'Category' && !$route->admin;
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
