<?php


namespace app\core;

use app\model\User;

class Auth
{
	protected static $user = [];

	public static function checkAuthorized(array $user, array $rights): void
	{
		if (!User::can($user, $rights)) {
			header("Location:/auth/unautherized");
		}
	}

	public static function getUser()
	{
		return self::$user;
	}


	public static function setAuth(array $user): void
	{
		$_SESSION['id'] = $user['id'];
	}

	public static function getAuth()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = User::find($_SESSION['id']);

			self::$user = $user ? $user->toArray() : null;
		}
	}


	public static function autorize(): array
	{
		if (Router::needsNoAuth()) {
			return [];
		}

		$user = self::getUser();
		if (!$user) {
			header("Location:/auth/login");
			exit();
		}

		if ($user === null) {
			$_SESSION['id'] = '';
			$errors[] = 'Неправильные данные для входа на сайт';
			header("Location:/auth/login");
			exit();
		}

		self::setAuth($user);
		if (!$user['confirm'] == "1") {
			$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			header("Location:/auth/noconfirm");
			exit();
		}

		if ($user['email'] === $_ENV['SU_EMAIL']) {
			define('SU', true);
		}
		return $user;

	}

}

