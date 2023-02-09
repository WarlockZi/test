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

//		View::setAssets($route);
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

	public function set($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function badToken(array $data):bool
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

	public function isAjax(): array
	{
		if (isset($_POST['param'])) {

			$req = json_decode($_POST['param'], true);
			if ($this->badToken($req)) return [];

			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
				=== 'xmlhttprequest') {
				unset($req['token']);
				$this->ajax = $req;
				return $req;
			}
		}
		return [];
	}

}
