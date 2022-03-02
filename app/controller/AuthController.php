<?php

namespace app\controller;

use app\core\App;
use app\model\Mail;
use app\model\User;
use app\view\View;

class AuthController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
	}

	public function actionRegister()
	{
		if ($user = $this->ajax) {

			if (!$user['password']) exit('empty password');
			if (!$user['email']) exit('empty email');
			$found = App::$app->user->findOneWhere('email', $user['email']);
			if ($found) exit('mail exists');

			$hash = md5(microtime());
			$user['password'] = $this->preparePassword($user['password']);
			$user['hash'] = $hash;

			if (!App::$app->user->create($user)) {
				exit('registration failed');
			}
			$data['subject'] = "Регистрация VITEX";
			$data['to'] = [$user['email']];
			$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/auth/confirm?hash={$hash}";
			$data['body'] = $this->prepareBodyRegister($href, $hash);
			$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>>";

			try {
				$sent = Mail::send_mail($data);
				exit('confirm');
			} catch (\Exception $e) {
				exit($e->getMessage());
			}

		}
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	private function prepareBodyRegister($href, $hash)
	{
		ob_start();
		require ROOT . '/app/view/Auth/email.php';
		$template = ob_get_clean();
		return $template;
	}


	public function actionLogout()
	{
		if (isset($_COOKIE[session_name()])) {  // session_name() - получаем название текущей сессии
			setcookie(session_name(), '', time() - 86400, '/');
		}
		unset($_SESSION);
		header("Location: /");
	}

	private function confirm($user)
	{

		return null;
	}

	public function actionConfirm()
	{
		$hash = $_GET['hash'];
		if (!$hash) header('Location:/');
		$user = App::$app->user->findOneWhere('hash', $hash);
		if ($user) {
			$user['confirm']="1";
			if (App::$app->user->update($user)) {
				$this->setAuth($user);
				header('Location:/auth/cabinet');
				$this->exitWith('"Вы успешно подтвердили свой E-mail."');
			}
		}
		header('Location:/auth/login');
		exit();
	}


	public function actionCabinet()
	{
		$this->autorize();

		if (User::can($this->user, 'role_employee')) {
			header("Location:/adminsc");
		} else {
			View::setCss('auth.css');
			View::setJs('auth.js');
		}
	}

	public function actionChangePassword()
	{
		$this->autorize();
		if ($data = $this->ajax) {
			$old_password = $this->preparePassword($data['old_password']);

			if ($user = App::$app->user->findOneWhere('password', $old_password)) {
				$user['password'] = $this->preparePassword($data['new_password']);
				App::$app->user->update($user);
				exit('ok');
			}
			exit('fail');
		}

		View::setCss('auth.css');
		View::setJs('auth.js');
	}

	private function randomPassword()
	{
		$arr = [
			'1234567890',
			'abcdefghijklmnopqrstuvwxyz',
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		];

		$pass = array(); //remember to declare $pass as an array

		$arrLength = count($arr) - 1;
		$y = 0;
		for ($i = 0; $i < 8; $i++) {
			if ($y > $arrLength) $y = 0;
			$arrChosen = $arr[$y];
			$arrChosernLen = strlen($arrChosen) - 1;
			$n = rand(0, $arrChosernLen);
			$pass[] = $arrChosen[$n];
			$y++;
		}
		return implode($pass); //turn the array into a string
	}

	public function actionReturnpass()
	{
		if ($data = $this->ajax) {

			$_SESSION['id'] = '';
			$user = App::$app->user->findOneWhere('email', $data['email']);

			if ($user) {
				$password = $this->randomPassword();
				$user['password'] = $this->preparePassword($password);
				App::$app->user->update($user);

				$data['to'] = [$data['email']];
				$data['subject'] = 'Новый пароль';
				$data['body'] = "Ваш новый пароль: " . $password;

				Mail::send_mail($data);
				$this->exitWith('Новый пароль проверьте на почте');
			} else {
				$this->exitWith("Пользователя с таким e-mail нет");
			}

		}
		View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
		View::setJs('auth.js');
		View::setCss('auth.css');
	}


	public function actionLogin()
	{
		if ($data = $this->ajax) {
			$email = (string)$data['email'];
			$password = (string)$data['password'];

			if (!User::checkEmail($email)) {
				$msg[] = "Неверный формат email";
				$this->exitWith("Неверный формат email");
			}

			if (!User::checkPassword($password)) {
				$msg[] = "Пароль не должен быть короче 6-ти символов";
				$this->exitWith("Пароль не должен быть короче 6-ти символов");
			}

			$user = App::$app->user->findOneWhere("email", $email);

			if (!$user) $this->exitWith('not_registered');
			if ($user['password'] !== $this->preparePassword($password)) $this->exitWith('wrong pass');// Если данные правильные, запоминаем пользователя (в сессию)
			$user['rights'] = explode(",", $user['rights']);
			$this->setAuth($user);
			$this->exitWith('ok');

		}
		View::setJs('auth.js');
		View::setCss('auth.css');

	}


}
