<?php

namespace app\controller;

use app\core\App;
use http\Message;

class AppController extends Controller
{
	protected $ajax;

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
	function auth()
	{
		try {
//			unset($_SESSION['id']);
			if (isset($_SESSION['id']) && !$_SESSION['id'] && $_SERVER['QUERY_STRING'] != '') { // REDIRECT на регистрацию, если запросили не корень
				throw new \Exception(\Exception );
			} elseif (isset($_SESSION['id'])) {
				// Проверяем существует ли пользователь и подтвердил ли регистрацию
				$user = App::$app->user->getUser($_SESSION['id']);

				if ($user === false) {
					// Если пароль или почта неправильные - показываем ошибку
					$errors[] = 'Неправильные данные для входа на сайт';
				} elseif ($user === NULL) {
					// Пароль почта в порядке, но нет подтверждения
					$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
				} else {
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
