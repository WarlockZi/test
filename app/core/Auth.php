<?php


namespace app\core;

use app\controller\AppController;
use app\controller\AuthController;
use app\model\User;
use app\model\Illuminate\User as IlluminateUser;

class Auth extends AppController
{

	public static function checkAuthorized(array $user, array $rights)
	{
		if (!User::can($user, $rights)) {
			header("Location:/auth/unautherized");
		}
	}

	public static function setAuth($user)
	{
		$_SESSION['id'] = (int)$user['id'];
	}

	public static function autorize()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = IlluminateUser::find($_SESSION['id'])->toArray();
			if ($user === false) {
				$_SESSION['id'] = '';
				$errors[] = 'Неправильные данные для входа на сайт';
				header("Location:/user/login");
			} elseif (!$user['confirm'] == "1") {
				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
				header("Location:/auth/noconfirm");
			} else {
				if ($user['email'] === $_ENV['SU_EMAIL']) {
					define('SU', true);
				}
				$this->user = $user;
			}
		}

		header("Location:/auth/login");
		exit();
	}

	public static function auth()
	{
		$user = $this->user = AuthController::user();
		if ($this->user === false) {
			$errors[] = 'Неправильные данные для входа на сайт';
		} else {
			$this->set(compact('user'));
		}
	}
}