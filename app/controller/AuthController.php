<?php

namespace app\controller;

use app\model\Illuminate\User as IlluminateUser;
use app\model\Mail;
use app\model\User;
use app\view\Header\Header;
use app\view\User\UserView;
use app\view\View;

class AuthController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	public function actionRegister()
	{
		if ($user = $this->ajax) {

			if (!$user['password']) exit('empty password');
			if (!$user['email']) exit('empty email');

			$found = IlluminateUser::where('email', $user['email'])->first();
			if ($found) $this->exitWithMsg('mail exists');

			$hash = md5(microtime());
			$user['password'] = $this->preparePassword($user['password']);
			$user['hash'] = $hash;

			$data['subject'] = "Регистрация VITEX";
			$data['to'] = [$user['email']];
			$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/auth/confirm/{$hash}";
			$data['body'] = $this->prepareBodyRegister($href, $hash);
			$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>";

			try {
				$user['rights'] = 'user_update';
				if (!$id = User::create($user, 'register')) {
					exit('registration failed');
				}
				$sent = Mail::send_mail($data);
				$this->exitWithMsg('confirmed');
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}
	}

	public function actionProfile()
	{
		$this->autorize();
		$this->view = 'profile1';

		$user = IlluminateUser::find($_SESSION['id']);
		$userArr = IlluminateUser::find($_SESSION['id'])->toArray();

		if (User::can($userArr, 'role_employee')) {
			Header::getAdninHeader($this);
			$this->layout = 'admin';
			if (User::can($userArr, 'role_admin')) {
				$item = UserView::admin($user);
			} else {
				$item = UserView::employee($user);
			}

			View::unsetJs('auth.js');
			View::unsetCss('auth.css');

			View::setJs('admin.js');
			View::setCss('admin.css');
		} else {
			$item = UserView::guest($user);;
			$this->layout = 'vitex';
		}

		$this->set(compact('item'));
	}

	public function actionChangePassword()
	{
		$this->autorize();
		if ($data = $this->ajax) {
			if (!$data['old_password'] || !$data['new_password'])
				$this->exitWithError('Заполните старый и новый пароль');

			$old_password = $this->preparePassword($data['old_password']);

			$user = IlluminateUser::where('password', $old_password)
				->get()->toArray();

			if ($user) {
				$user = $user[0];
				$newPassword = $this->preparePassword($data['new_password']);
				$res = User::update(['id' => $user['id'], 'password' => $newPassword]);
				if ($res) {

					$this->exitWithSuccess('Пароль поменeн');
				} else {
					$this->exitWithMsg('Что-то пошло не так (');
				}
			} else {

				$this->exitWithError('Не правильный старый пароль (');
			}
		}
	}

	public function actionReturnpass()
	{
		if ($data = $this->ajax) {

			$_SESSION['id'] = '';
			$user = IlluminateUser::where('email', $data['email'])
				->select('id', 'password', 'email')
				->get()[0]
				->toArray();

			if ($user) {
				$this->setAuth($user);
				$password = $this->randomPassword();
				$newPassword = $this->preparePassword($password);
				User::update(['id' => $user['id'], 'password' => $newPassword]);

				$data['to'] = [$data['email']];
				$data['subject'] = 'Новый пароль';
				$data['body'] = "Ваш новый пароль: " . $password;

				Mail::send_mail($data);
				$this->exitWithSuccess('Новый пароль проверьте на почте');
			} else {
				$this->exitWithError("Пользователя с таким e-mail нет");
			}
		}
		View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
	}

	public function actionLogin()
	{
		if ($data = $this->ajax) {

			$email = (string)$data['email'];
			$password = (string)$data['password'];

			if (!User::checkEmail($email)) $this->exitWithError("Неверный формат email");
			if (!User::checkPassword($password)) $this->exitWithError("Пароль не должен быть короче 6-ти символов");

			$user = IlluminateUser::where('email', $email)->get()[0]
				->toArray();

			if (!$user) $this->exitWithError('Пользователь не зарегистрирован');
			if (!$user['confirm']) $this->exitWithSuccess('Зайдите на почту чтобы подтвердить регистрацию');
			if ($user['password'] !== $this->preparePassword($password))
				$this->exitWithError('Не верный email или пароль');// Если данные правильные, запоминаем пользователя (в сессию)
			$this->setAuth($user);
			$this->user = $user;
			if (User::can($user, 'role_employee')) {
				$this->exitJson(['role' => 'employee']);
			} else {
				$this->exitJson(['role' => 'user']);
			}
		}

		$this->view = 'login';
		$this->layout = 'vitex';
	}

	public function actionLogout()
	{
		if (isset($_COOKIE[session_name()])) {  // session_name() - получаем название текущей сессии
			setcookie(session_name(), '', time() - 86400, '/');
		}
		unset($_SESSION);
		header("Location: /");
		exit();
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


	public function actionConfirm()
	{
		$hash = $this->route['id'];

		if (!$hash) header('Location:/');
		$user = IlluminateUser::where('hash', $hash)->get()[0]->toArray();
		if ($user) {
			$user['confirm'] = "1";
			$this->setAuth($user);
			if (User::update($user)) {
				header('Location:/auth/success');
				$this->exitWithPopup('"Вы успешно подтвердили свой E-mail."');
			}
		}
		header('Location:/auth/login');
		exit();
	}


	private function prepareBodyRegister($href, $hash)
	{
		ob_start();
		require ROOT . '/app/view/Auth/email.php';
		return ob_get_clean();
	}

	public function actionSuccess()
	{
		$this->auth();
	}

	public static function user()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = \app\model\Illuminate\User::find($_SESSION['id'])->toArray();
			if (!$user) {
				exit(json_encode(['popup' => 'Неправильные данные для входа на сайт']));
			}
			return $user;
		}
	}

	public function actionCabinet()
	{
		$this->auth();
	}

	public function actionNoconfirm()
	{
		$errorss = 4;
	}
}
