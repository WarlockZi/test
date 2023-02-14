<?php


namespace app\core;


use app\controller\Controller;
use app\view\View;

class NotFound
{

	public static function url(string $url, View $view)
	{
		$error = "Плохой запрос url - {$url}";
		Error::setError($error);
		$view->route = ['controller' => 'AppController', 'action' => 'index'];
		$view->render();
		exit();
	}

	public static function controller(string $controller, View $view)
	{
		$error = "Плохой запрос controller - {$controller}";
		Error::setError($error);
		$view->render();
		exit();
	}

	public static function action(string $action, Controller $controller, View $view)
	{
		$error = "Плохой запрос action - {$action} у контроллера - {$controller->shortClassName($controller)}";
		Error::setError($error);
		$view->render();
		exit();
	}

}