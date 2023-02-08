<?php

namespace app\controller;

use app\view\View;

abstract class Controller
{
	public $route;
	public $view;
	public $layout;
	public $vars = [];
	protected $token;
	protected $ajax;

	function __construct($route)
	{
		$this->route = $route;

		$this->view = $route['action'];
		$this->token = !empty($_SESSION['token'])
      ? $_SESSION['token']
      : $this->createToken();

		View::setAssets($route);
	}

	public static function getNameSpace($route)
	{
		if (isset($route['admin']) && $route['admin']) {
			return 'app\controller\admin\\';
		}
		return 'app\controller\\';
	}

	protected function createToken()
	{
		$salt = "popiyonovacheesa";
		return $_SESSION['token'] = md5($salt . microtime(true));
	}

	public function getView()
	{
		$view = new View($this->route, $this->layout, $this->view, $this->user);
		$view->render($this->vars);
	}

	protected function getPaths($absolutePath)
	{
		$paths = [];
		foreach (scandir("{$absolutePath}/") as $path) {
			if ($path !== '.' && $path !== '..') {
				$paths[$path]['basename'] = $path;
				$paths[$path]['fullpath'] = "{$absolutePath}/{$path}";
			}
		}
		return $paths;
	}

	public function set($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}
  public function setError(string $errrorString)
  {
    $this->vars = array_merge($this->vars, $vars);
  }

	public function badToken($data)
	{
		if (!$data) return false;
		if (!$data['token']
			&& !$_SESSION['token'] === $_POST['token']
		) {
			unset($data['token']);
			return true;
		}
		return false;
	}

	public function isAjax()
	{
		if (isset($_POST['param'])) {

			$req = json_decode($_POST['param'], true);
			if ($this->badToken($req)) return false;

			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
				=== 'xmlhttprequest') {
				unset($req['token']);
				$this->ajax = $req;
				return $req;
			}
		}
		return false;
	}

}
