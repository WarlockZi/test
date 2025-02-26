<?php

namespace app\controller;

use app\Actions\AuthAction;
use app\core\Auth;
use app\core\Mail\PHPMail;
use app\model\User;
use app\Repository\UserRepository;
use app\Services\TelegramBot\TelegramBot;
use app\view\User\UserView;

class AuthController extends AppController
{
	protected $mailer;
	protected $actions;

	public function __construct()
	{
		parent::__construct();
//		$bot = new TelegramBot();
//		$bot->send('Что так');

		$this->actions = new AuthAction();
		$this->mailer = new PHPMail('env');
		if (!$this->ajax) {
			$this->assets->setAuth();
		}
	}

	public function actionRegister()
	{
		$req = $this->ajax;
		if ($req) {
			if (!$req['email']) exit('empty email');
			$found = User::where('email', $req['email'])->first();
			if ($found) $this->exitWithMsg('mail exists');

			if (!$req['password']) exit('empty password');

			$user = $this->actions->createUser($req);
			if ($user) {
				$userMessage = "Пользователь создан";
			} else {
				$userMessage = "Пользователь не создан";
			}

			$sent = $this->mailer->sendRegistrationMail($user);

			$this->exitJson(['message' => 'confirmed', 'popup' => $userMessage . "\n" . $sent]);
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
			if (!$user['password'] === $this->actions->preparePassword($data['password']))
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

			$old_password = $this->actions->preparePassword($data['old_password']);

			$user = User::where('password', $old_password)
				->get()->toArray();

			if ($user) {
				$user = $user[0];
				$newPassword = $this->actions->preparePassword($data['new_password']);
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
			$user = UserRepository::returnPassword($data);

			if ($user) {
				$password = $this->actions->randomPassword();
				$newPassword = $this->actions->preparePassword($password);
				User::where('id', $user['id'])
					->update(['password' => $newPassword]);

				$this->mailer->returnPassword($data);
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


	public function actionConfirm()
	{
		$hash = $this->route->id;

		if (!$hash) header('Location:/');
		$user = User::where('hash', $hash)->first();

		if (!$user) {
			header('Location:/auth/login');
			exit();
		}

		$user['confirm'] = "1";
		Auth::setAuth($user->toArray());
		if ($user->update()) {
			header('Location:/auth/success');
			$this->exitWithPopup('"Вы успешно подтвердили свой E-mail."');
		}

	}


	public static function user()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) return false;

		$user = User::where('id', $_SESSION['id'])->first();
		if (!$user) return false;

		return $user->toArray();

	}

	public function actionUnautherized()
	{
		$view = 'unautherized';
	}

	public function actionUnsubscribe()
	{
		$view = 'unautherized';
	}
}
