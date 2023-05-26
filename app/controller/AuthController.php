<?php

namespace app\controller;

use app\core\Auth;
use app\core\Mail;
use app\model\User;
use app\view\User\UserView;
use app\view\View;
use Exception;

class AuthController extends AppController
{
	protected string $salt = "popiyonovacheesa";

	public function __construct()
	{
		parent::__construct();
		if (!$this->ajax) {
			$this->assets->setAuth();
//			$this->assets->setCss('auth');
		}
	}

	public function actionLogin()
	{
		if ($data = $this->ajax) {

			if (!User::checkEmail($data['email'])) $this->exitWithError("Неверный формат email");
			if (!User::checkPassword($data['password'])) $this->exitWithError("Пароль не должен быть короче 6-ти символов");

			$user = User::where('email', $data['email'])->first()
				? User::where('email', $data['email'])->first()->toArray()
				: null;

			if (!$user) $this->exitWithError('Пользователь не зарегистрирован');
			if (!$user['confirm']) $this->exitWithSuccess('Зайдите на почту чтобы подтвердить регистрацию');
			if (!$user['password'] === $this->preparePassword($data['password']))
				$this->exitWithError('Не верный email или пароль');// Если данные правильные, запоминаем пользователя (в сессию)
			Auth::setAuth($user);
			$this->user = $user;
			if (User::can($user, ['role_employee'])) {
				$this->exitJson(['role' => 'employee']);
			} else {
				$this->exitJson(['role' => 'user']);
			}
		}

		$this->view = 'login';
		$this->layout = 'vitex';
	}

	public function actionRegister()
	{
		if ($user = $this->ajax) {
			if (!$user['password']) exit('empty password');
			if (!$user['email']) exit('empty email');

			$found = User::where('email', $user['email'])->first();
			if ($found) $this->exitWithMsg('mail exists');

			$user['password'] = $this->preparePassword($user['password']);
			$user['hash'] = md5(microtime());
			$user['rights'] = 'user_update';
			$user['sex'] = 'm';

			$data = Mail::mailConfirmFactory($user);

			$user = User::create($user);
			$user->save();

			if (!$user) {
				exit('registration failed');
			}
			try {
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= "To: <vvoronik@yanedex.ru>\r\n";
				$headers .= "From: <vitexopt@vitexopt.ru>\r\n";
				if (mail('vvoronik@yanedex.ru', "Подтвердите Email на сайте", 'f',$headers)) {
					// Если да, то выводит сообщение
					echo 'Подтвердите на почте';
				}
//				Mail::send_mail($data);
			} catch (Exception $e) {
				exit($e->getMessage());
			}
			$this->exitWithMsg('confirmed');

		}
	}

	public function actionProfile()
	{
		$userArr = Auth::getUser();
		$user = User::find($userArr['id']);

		if (User::can($userArr, ['role_employee'])) {
			if (User::can($userArr, ['role_admin'])) {
				$item = UserView::admin($user);
			} else {
				$item = UserView::employee($user);
			}

			$this->assets->unsetJs('auth.js');
			$this->assets->unsetCss('auth.css');

		} else {
			$this->layout = 'vitex';
			$item = UserView::guest($user);;
		}

		$this->set(compact('item'));
	}

	public function actionChangePassword()
	{
		if ($data = $this->ajax) {
			if (!$data['old_password'] || !$data['new_password'])
				$this->exitWithError('Заполните старый и новый пароль');

			$old_password = $this->preparePassword($data['old_password']);

			$user = User::where('password', $old_password)
				->get()->toArray();

			if ($user) {
				$user = $user[0];
				$newPassword = $this->preparePassword($data['new_password']);
				$res = User::where('id', $user['id'])
					->update(['password' => $newPassword]);
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
			$user = User::where('email', $data['email'])
				->select('id', 'password', 'email')
				->get()[0]
				->toArray();

			if ($user) {
				$password = $this->randomPassword();
				$newPassword = $this->preparePassword($password);
				User::where('id', $user['id'])
					->update(['password' => $newPassword]);

				$data['to'] = [$data['email']];
				$data['subject'] = 'Новый пароль';
				$data['body'] = "Ваш новый пароль: " . $password;

				Mail::send_mail($data);
				$this->exitWithSuccess('Новый пароль проверьте на почте');
			} else {
				$this->exitWithError("Пользователя с таким e-mail нет");
			}
		}
	}


	public function actionLogout()
	{
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 86400, '/');
		}
		unset($_SESSION);
		header("Location: /");
		exit();
	}

	private function randomPassword(): string
	{
		$arr = [
			'1234567890',
			'abcdefghijklmnopqrstuvwxyz',
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		];

		$pass = array();

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
		return implode($pass);
	}


	public function actionConfirm()
	{
		$hash = $this->route['id'];

		if (!$hash) header('Location:/');
		$user = User::where('hash', $hash)->first();
		if ($user) {
			$user['confirm'] = "1";
//			Auth::setAuth($user);
			if ($user->update()) {
				header('Location:/auth/success');
				$this->exitWithPopup('"Вы успешно подтвердили свой E-mail."');
			}
		}
		header('Location:/auth/login');
		exit();
	}

	public function actionSuccess()
	{
//		Auth::autorize($this);
	}

	public static function user()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) return false;

		$user = User::where('id', $_SESSION['id'])->first();
		if (!$user) return false;

		return $user->toArray();

	}

	public function actionCabinet()
	{

	}

	public function actionNoconfirm()
	{
		$errorss = 4;
	}

	public function actionUnautherized()
	{
		$view = 'unautherized';
	}

	public function preparePassword(string $password): string
	{
		return md5($password . $this->salt);
	}
}
