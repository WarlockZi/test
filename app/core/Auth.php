<?php


namespace app\core;

use app\controller\AppController;
use app\controller\Controller;
use app\model\User;

class Auth extends AppController
{

	public static function checkAuthorized(array $user, array $rights): void
	{
		if (!User::can($user, $rights)) {
			header("Location:/auth/unautherized");
		}
	}

	public static function setAuth(): void
	{
		Session::setUser();
	}


	public static function autorize(): void
	{
		if (Router::isLogin(Router::getRoute())) {
			return;
		}
		Session::setUser();
		if (!Session::getUser()) {
			header("Location:/auth/login");
			exit();
		}

		$user = Session::getUser();

		if ($user === null) {
			$_SESSION['id'] = '';
			$errors[] = 'Неправильные данные для входа на сайт';
			header("Location:/auth/login");
			exit();
		}
		if (!$user['confirm'] == "1") {
			$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			header("Location:/auth/noconfirm");
			exit();
		}

		if ($user['email'] === $_ENV['SU_EMAIL']) {
			define('SU', true);
		}

	}

}

