<?php

namespace app\controller;

use app\core\App;
use app\model\Mail;
use app\model\User;
use app\view\View;
use app\controller\AdminscController;

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
			$found = App::$app->user->findWhere('email', $user['email']);
			if ($found) exit('mail exists');

			$hash = md5(microtime());
			$user['password'] = $this->preparePassword($user['password']);
			$user['hash'] = $hash;

//			if (!App::$app->user->create($user)) {
////				exit('registration failed');
////			}
			$data['subject'] = "Регистрация VITEX";
			$data['to'] = [$user['email']];
			$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/auth/confirm?hash={$hash}";
			$data['body'] = $this->prepareBodyRegister($href, $hash);
			$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>>";

			try {
				App::$app->mail->send_mail($data);
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

	public function actionConfirm()
	{
		$hash = $_GET['hash'];
		if (!$hash) header('Location:/');
		if (!App::$app->user->confirm($hash)) exit('Не удалось подтвердить почту');
		header('Location:/auth/cabinet');
		exit();
	}

	public function actionCabinet()
	{
		$this->autorize();

		if (!User::can($this->user, 'gate_admin')) {
			if ($_SESSION['id']) {
				$user = App::$app->user->findOne($_SESSION['id']);
				$this->set(compact('user'));
			}

			View::setCss('auth.css');
			View::setJs('auth.js');
		} else {
			header("Location:/adminsc");
		}
	}

	public function actionChangePassword()
	{
		$this->autorize();
		if ($data = $this->ajax) {
			$old_password = $this->preparePassword($data['old_password']);

			if ($user = App::$app->user->findWhere('password', $old_password)) {
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
			$email = $data['email'];

			$_SESSION['id'] = '';
			$user = App::$app->user->findWhere('email', $email);

			if ($user) {
				$password = $this->randomPassword();
				$user['password'] = $this->preparePassword($password);
				App::$app->user->update($user);

				$data['to'] = [$email];
				$data['subject'] = 'Новый пароль';
				$data['body'] = "Ваш новый пароль: " . $password;

				Mail::send_mail($data);
				exit(json_encode(['msg' => 'Новый пароль проверьте на почте']));
			} else {
				exit(json_encode(["msg" => "Пользователя с таким e-mail нет"]));
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
				exit(json_encode(["msg" => "Неверный формат email"]));
			}

			if (!User::checkPassword($password)) {
				$msg[] = "Пароль не должен быть короче 6-ти символов";
				exit(json_encode(["msg" => "Пароль не должен быть короче 6-ти символов"]));
			}

			$user = App::$app->user->findWhere("email", $email);

			if ($user === null || !$user) {
				exit(json_encode(['msg' => 'not_registered']));
			} elseif ($user['password'] !== $this->preparePassword($password)) {
				exit('fail');
			} // Если данные правильные, запоминаем пользователя (в сессию)
			$user['rights'] = explode(",", $user['rights']);
			$this->setAuth($user);
			exit(json_encode(['msg' => 'ok']));

		}
		View::setJs('auth.js');
		View::setCss('auth.css');

	}



}
