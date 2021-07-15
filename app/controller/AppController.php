<?php

namespace app\controller;

use app\core\App;
use http\Message;

class AppController extends Controller
{
	protected $ajax;
	protected $user;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->layout = 'vitex';
		$this->isAjax();

		if (strpos(strtolower($route['controller']), 'adminsc') === false) {
			$l = App::$app->category->getAssocCategory(['active' => 'true']);
			$list = App::$app->category->categoriesTree($l);
			$this->set(compact('list'));
		}
	}


	public
	function setAuth($user)
	{
		if (!isset($_SESSION['id']) || !$_SESSION['id']) {
			$_SESSION['id'] = (int)$user['id'];
		}
	}
	public
	function auth()
	{
		if (!isset($_SESSION['id'])||!$_SESSION['id']){
			header("Location:/user/login");
			exit();
		}

		try {
			if (isset($_SESSION['id']) && !$_SESSION['id'] && $_SERVER['QUERY_STRING'] != '') {
				throw new \Exception('Зарегистрируйтесь ' );
			} elseif (isset($_SESSION['id'])) {
				$user = $this->user = App::$app->user->get($_SESSION['id']);

				if ($this->user === false) {
					$errors[] = 'Неправильные данные для входа на сайт';
					header("Location:/user/login");
				} elseif ($this->user === NULL) {
					$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
				} else {
					if ($user['email']===$_ENV['SU_EMAIL']){
						define('SU', true);
					}
					$this->set(compact('user'));

				}
			} elseif (!isset($_SESSION['id'])) {
				header("Location:/user/login");
				$_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
				exit();
			}
		} catch (\Exception $e) {
			header("Location:/user/login");
			$_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
			exit();
		};
	}

}
