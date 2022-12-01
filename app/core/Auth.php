<?php


namespace app\core;

use app\controller\AppController;
use app\model\User;

class Auth extends AppController
{

	public static function checkAuthorized(array $user, array $rights): void
	{
		if (!User::can($user, $rights)) {
			header("Location:/auth/unautherized");
		}
	}

	public static function setAuth(int $userId): void
	{
		$_SESSION['id'] = $userId;
	}

	public static function sessionHasUserId()
	{
		return isset($_SESSION['id']) && $_SESSION['id'];
	}

	public static function autorize($Controller): void
	{

		if (!self::sessionHasUserId()) {
			header("Location:/auth/login");
			exit();
		}

		$user = User::find($_SESSION['id'])->toArray();

		if ($user === false) {
			$_SESSION['id'] = '';
			$errors[] = 'Неправильные данные для входа на сайт';
			header("Location:/user/login");
			exit();

		} elseif (!$user['confirm'] == "1") {
			$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			header("Location:/auth/noconfirm");
			exit();

		} else {
			if ($user['email'] === $_ENV['SU_EMAIL']) {
				define('SU', true);
			}
			$Controller->user = $user;
		}
	}

}

