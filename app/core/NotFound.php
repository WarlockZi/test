<?php


namespace app\core;

use app\controller\Controller;
use app\model\User;
use app\view\AdminView;
use app\view\UserView;

class NotFound extends Controller
{
	protected $file404;

	public function __construct()
	{
		$this->file404 = ROOT.'/app/view/404/index.php';
	}

	public function getModel(){

	}

	public static function url(string $url)
	{
		$error = "Плохой запрос url - {$url}";
		Error::setError($error);

		$view = self::setView();
		$view->route = ['controller' => 'AppController', 'action' => 'index'];
		$view->render();
		exit();
	}

	public static function controller(Route $route)
	{
		$error = "Плохой запрос controller - {$route->controller}";
		Error::setError($error);

		$controller = new self();
//		$controller->route->setController(static::class);

		$view = self::setView($route);
		$view->controller = new $controller;
		$content = FS::getFileContent($controller->file404);
		$view->controller->set(compact('content'));
		$view->render();
		exit();
	}

	public static function action(Route $route)
	{
		$error = "Плохой запрос action - {$route->action} у контроллера - {$route->controller->shortClassName($route->controller)}";
		Error::setError($error);
		$view = self::setView($route);
		$view->render();
		exit();
	}

	protected static function setView(Route $route){
		if (User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView(new self);
		} else {
			return new UserView(new self);
		}
	}

}