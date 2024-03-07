<?php


namespace app\controller;

use app\controller\Controller;
use app\model\User;
use app\view\AdminView;
use app\view\Assets\UserAssets;
use app\view\UserView;

class NotFoundController extends Controller
{
	protected $file404;
	public $view;

	public function __construct()
	{
		parent::__construct();
		$this->assets = new UserAssets();
		$this->assets->setMeta('Страница не найдена', 'Страница не найдена');
		$this->file404 = ROOT.'/app/view/404/index.php';
	}

	public function controller(Route $route)
	{
		$error = "Не найден controller - {$route->getController()}";
		http_response_code(404);
		Error::setError($error);
		$view = $this->setView();
		$view->render();
		exit();
	}

	public function action(Route $route)
	{
		$error = "Плохой action - {$route->getAction()} у контроллера - {$route->getController()}";
		http_response_code(404);
		Error::setError($error);
		$view = $this->setView();
		$view->render();
		exit();
	}

	public function setView(){
		if (User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView(new self);
		} else {
			return new UserView(new self);
		}
	}

}