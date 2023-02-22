<?php


namespace app\core;


use app\controller\Controller;
use app\model\User;
use app\view\AdminView;
use app\view\UserView;

class NotFound extends Controller
{

	public static function url(string $url)
	{
		$error = "Плохой запрос url - {$url}";
		Error::setError($error);
//		Router::setController('AppController');
		$view = self::setView();
		$view->route = ['controller' => 'AppController', 'action' => 'index'];
		$view->render();
		exit();
	}

	public static function controller(string $controller)
	{
		$error = "Плохой запрос controller - {$controller}";
		Error::setError($error);
		$view = self::setView();
		$view->controller = new $controller;
		$view->render();
		exit();
	}

	public static function action(string $action, Controller $controller)
	{
		$error = "Плохой запрос action - {$action} у контроллера - {$controller->shortClassName($controller)}";
		Error::setError($error);
		$view = self::setView();
		$view->render();
		exit();
	}

	protected static function setView(){
		if (Router::getRoute()->isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView(new self);
		} else {
			return new UserView(new self);
		}
	}

}