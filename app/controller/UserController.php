<?php

namespace app\controller;

use app\view\View;
use app\model\Mail;
use app\core\App;

use app\model\User;


class UserController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
	}

	public function actionRegister()
	{
		if ($data = $this->ajax) {

			if (!$data['password']) exit('empty password');
			if (!$data['email']) exit('empty email');
			$data['to'] = [$data['email']];
			$user = App::$app->user->findWhere('email', $data['to'][0]);
			if ($user) exit('mail exists');

			$hash = md5(microtime());
			$user['rights'] = '2';
			$user['surName'] = $data['surName'];
			$user['name'] = $data['name'];
			$user['email'] = $data['to'][0];
			$user['password'] = md5($data['password'] . $this->salt);
			$user['hash'] = $hash;

			if (!App::$app->user->create($user)) {
				exit('registration failed');
			}
			$data['subject'] = "Регистрация VITEX";
			$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/user/confirm?hash={$hash}";
			$data['body'] = $this->prepareBodyRegister($href, $hash);
			$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>>";

			try {
				Mail::send_mail($data);
				exit('confirm');
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
//			$overlay = $this->registerGetOverlay();
		}
		View::setMeta('Регистрация', 'Регистрация', 'Регистрация');
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	private function prepareBodyRegister($href, $hash)
	{
		ob_start();
		require ROOT . '/app/view/User/email.php';
		$template = ob_get_clean();
		return $template;
	}

	private function registerGetOverlay()
	{
		$msg[] = "Для подтвержения регистрации перейдите по ссылке в <br><a href ='https://mail.vitexopt.ru/webmail/login/'>ПОЧТЕ</a>.<br>Письмо может попасть в папку 'Спам'";
		ob_start();
		include ROOT . '/app/view/User/alert.php';
		return ob_get_clean();
	}

	public function actionUnsubscribe()
	{
		exit('unsubscribed');
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
		if (!$hash) {
			header('Location:/');
		}
		if (!App::$app->user->confirm($hash)) {
			exit('Не удалось подтвердить почту');
		};
		header('Location:/user/cabinet');
		exit();
	}

	public function actionCabinet()
	{
		$this->auth();

		$userId = $_SESSION['id'];
		if ($userId){
			$user = App::$app->user->getUserById([$userId]);
			$this->set(compact('user'));
		}

		View::setMeta('Личный кабинет', 'Личный кабинет', '');
		View::setCss('cabinet.css');
		View::setJs('cabinet.js');

	}

	public function actionChangePassword()
	{
		$this->auth();
		if ($data = $this->ajax) {
			$old_password = $this->preparePassword($data['old_password']);
			if ($user = App::$app->user->findWhere('password', $old_password)[0]) {
				$user['password'] = $this->preparePassword($data['new_password']);
				App::$app->user->update($user);
				exit('ok');
			}
			exit('fail');
		}

		View::setMeta('Личный кабинет', 'Личный кабинет', '');
		View::setCss('auth.css');
		View::setJs('auth.js');
	}

	public function actionReturnPass()
	{
		if ($data = $this->ajax) {
			$this->returnPass($data['email'], $this->salt);
		}
		View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
		View::setJs('auth.js');
		View::setCss('auth.css');

	}


	public function returnPass($email, $salt)
	{
		$_SESSION['id'] = '';
		$user = App::$app->user->findWhere('email', $email)[0];

		if ($user) {
			$pass = substr(md5(rand()), 0, 7);
			$pPlusSalt = $pass . $salt;
			$user['password'] = md5($pPlusSalt);
			App::$app->user->update($user);

			$data['to'] = [$email];
			$data['subject'] = 'Новый пароль';
			$data['body'] = "Ваш новый пароль: " . $pass;

			Mail::send_mail($data);
			exit(json_encode(['msg' => 'Новый пароль проверьте на почте']));
		} else {
			exit(json_encode(["msg" => "Пользователя с таким e-mail нет"]));
		}

	}


	public function actionLogin()
	{
		if ($data = $this->ajax) {
			$email = (string)$data['email'];
			$password = (string)$data['password'] ;

			if (!User::checkEmail($email)) {
				$msg[] = "Неверный формат email";
				$_SESSION['error'][] = "Неверный формат email";
			}

			if (!User::checkPassword($password)) {
				$msg[] = "Пароль не должен быть короче 6-ти символов";
//				exit(include ROOT . '/app/view/User/alert.php');
			}

			$user = App::$app->user->findWhere("email", $email)[0];

			if ($user === null || !$user) {
				exit(json_encode(['msg' => 'not_registered']));
			} elseif ($user['password'] !== $this->preparePassword($password)) {
				exit('fail');
//			} elseif (!(int)$user['confirm']) {
//				$msg[] = 'зайдите на почту, с которой регистрировались.';
//				$msg[] = 'найдите письмо "Регистрация VITEX".';
//				$msg[] = 'перейдите по ссылке в письме.';
//				exit(json_encode(['msg' => 'not confirmed']));
			} else {// Если данные правильные, запоминаем пользователя (в сессию)
				$user['rights'] = explode(",", $user['rights']);
				$this->setAuth($user);
				exit(json_encode(['msg'=>'ok']));
			}
		}
		View::setJs('auth.js');
		View::setCss('auth.css');

	}

	public function actionEdit()
	{
		$this->auth();
		$user = App::$app->user->get($_SESSION['id']);
		if ($f = $this->ajax) {
			foreach ($f as $key => $value) {
				if (array_key_exists($key, $user)) {
					$user[$key] = $value;
				}
			}
		}
		$errors = false;
		if (!App::$app->user->checkName($f['name'])) {
			$errors[] = 'Имя не должно быть короче 2-х символов';
		}
		if ($errors == false) {
			$result = App::$app->user->update($user);
		}
		$this->set(compact('user'));

		View::setMeta('Профиль', 'Профиль', 'Профиль');
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	public function actionContacts()
	{
		$this->auth();
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}


}
