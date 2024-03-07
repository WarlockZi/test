<?php

namespace app\core;

use app\Exceptions\NoControllerException;
use app\Exceptions\NoMethodException;

class Router
{
	protected static $routes = [];
	protected $route;
	protected $namespace;
	protected $controller;
	protected $uri;
	protected $url;
	protected $params;

	public function __construct(string $uri)
	{
		$this->route = new Route();
		$this->uri = $uri;
		$this->url = $this->getUrl($uri);
		$this->fillRoutes();
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function matchRoute($url): Route
	{
		$route = $this->route;
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
					$route->$k = $v;
				}
//				$this->route = $route;
			}
		}
		return $route;
	}

	protected function setRoute()
	{
		$parcedRoute = $this->matchRoute($this->url);
		$parcedRoute->setUri($this->uri);
		$parcedRoute->setParams($this->params);
		$parcedRoute->setAmin($parcedRoute);
		$parcedRoute->setController($parcedRoute);
		$parcedRoute->setAction($parcedRoute);
		$parcedRoute->setHost();
		$parcedRoute->setProtocol();
	}

	public function dispatch()
	{
		$this->setRoute();

		$controller = $this->route->getController();
		if ($this->route->getControllerName()==="NotFound"){
			$this->errors[] = "Класс не существует";
		}
		$controller = new $controller;

		Auth::autorize($this->route);
		$action = $this->route->getActionName();
		if (!method_exists($controller, $action)) {
			http_response_code(404);
			include(ROOT . '/app/view/404/index.php'); // provide your own HTML for the error page
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

	public static function needsNoAuth($route)
	{
		return
			$route->getControllerName() === 'Auth' && $route->getAction() === 'login'
			|| $route->getControllerName() === 'Auth' && $route->getAction() === 'register'
			|| $route->getControllerName() === 'Auth' && $route->getAction() === 'returnpass'
			|| $route->getControllerName() === 'Auth' && $route->getAction() === 'noconfirm'
			|| $route->getControllerName() === 'Auth' && $route->getAction() === 'confirm'

			|| $route->getControllerName() === 'Cart'
			|| $route->getControllerName() === 'Main'
			|| $route->getControllerName() === 'Bot'
			|| $route->getControllerName() === 'Promotion'
			|| $route->getControllerName() === 'Orderitem'
			|| $route->getControllerName() === 'Search'

			|| $route->getControllerName() === 'Sync' && $route->getAction() === 'part'
			|| $route->getControllerName() === 'Sync' && $route->getAction() === 'init'
			|| $route->getControllerName() === 'Sync' && $route->getAction() === 'load'

			|| $route->getControllerName() === 'Main' && $route->getAction() === 'index'
			|| $route->getControllerName() === 'Product' && !$route->isAdmin()
			|| $route->getControllerName() === 'Category' && !$route->isAdmin()
			|| $route->getControllerName() === 'Github' && $route->getAction() === 'webhook';
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
