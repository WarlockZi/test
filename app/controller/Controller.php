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
		$this->token = !empty($_SESSION['token']) ? $_SESSION['token'] : $this->createToken();
	}

	protected function createToken()
	{
		$salt = "popiyonovacheesa";
		return $_SESSION['token'] = md5($salt . microtime(true));

	}

	public function getView()
	{
		$vObj = new View($this->route, $this->layout, $this->view, $this->user);
		$vObj->render($this->vars);
	}

	protected function getFiles($absolutePath)
	{
		$files = [];
		foreach (glob($absolutePath . "/*") as $file) {
			$path_parts = pathinfo($file);

			$files[$file]['size'] = filesize($file);
			$files[$file]['dirname'] = $path_parts['dirname'];
			$files[$file]['basename'] = $path_parts['basename'];
			$files[$file]['extension'] = $path_parts['extension'];
			$files[$file]['filename'] = $path_parts['filename'];
		}
		return $files;
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

// Передача данных в View
	public function set($vars)
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

			$data = json_decode($_POST['param'], true);
			if ($this->badToken($data)) return "Плохой запрос";

			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
				=== 'xmlhttprequest') {
				$this->ajax = $data;
				return $data;
			}
		}
		return false;
	}

}
