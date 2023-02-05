<?php


namespace app\core;


use app\controller\AppController;
use app\controller\Controller;

class NotFound
{

	public static function url(string $url){
		$error = "Плохой запрос url - {$url}";
		Error::setError($error);
		$route = ['controller'=>'AppController','action'=>'index'];
		$controller = new AppController($route);
		$controller->getView();
		exit();
	}

	public static function controller(string $controller, $route){
		$error = "Плохой запрос controller - {$controller}";
		Error::setError($error);
		$controller = new AppController($route);
		$controller->getView();
		exit();
	}

	public static function action(string $action, Controller $controller){
		$error = "Плохой запрос action - {$action} у контроллера - {$controller->shortClassName($controller)}";
		Error::setError($error);
		$controller->getView();
		exit();
	}

}