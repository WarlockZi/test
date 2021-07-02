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

			$to = [$data['email']];
			if (App::$app->user->checkEmailExists($to[0])) {
				exit(json_encode(['msg' => 'mail exists']));
			}
			$hash = md5(microtime());

			$values = [
				'rights' => 2,
				'surName' => $data['surName'],
				'name' => $data['name'],
				'email' => $to[0],
				'password' => md5($data['password']),
				'hash' => $hash,
			];
			if (!App::$app->user->create($values)){
				exit(json_encode(["msg"=>'Регистрация не удалась']));
			}

			$subj = "Регистрация VITEX";
			$body = Mail::prepareBodyRegister($hash);

			Mail::send_mail($subj, $body, $to);
			$overlay = $this->registerGetOverlay();

			exit(json_encode(['overlay' => $overlay, 'msg' => 'ok']));

		}
		View::setMeta('Регистрация', 'Регистрация', 'Регистрация');
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	private function registerGetOverlay(){
		$msg[] = "Для подтвержения регистрации перейдите по ссылке в <br><a href ='https://mail.vitexopt.ru/webmail/login/'>ПОЧТЕ</a>.<br>Письмо может попасть в папку 'Спам'";
		ob_start();
		include ROOT . '/app/view/User/alert.php';
		return ob_get_clean();
	}

//	private function registrationGetEmailBody($subj, $email, $mail_body)
//	{
//		return <<< HERETEXT
//<h2>Новое письмо $subj</h2>
//<b>Имя:</b> dd<br>
//<b>Почта:</b> $email<br><br>
//<b>Сообщение:</b><br>$mail_body
//HERETEXT;
//	}

//	public function send_mail($email, $subj, $mail_body)
//	{
//		$body = $this->registrationGetEmailBody($subj, $email, $mail_body);
//		$from = 'vvoronik@yandex.ru';
//		$to[] = $email;
//		if (!Mail::send_mail($subj, $body, $to, $from)) {
//			echo json_encode(["result" => "error"]);
//		}
//	}


	public function regDataWrong($email, $password, $name, $surName)
	{
		if (isset($_POST)) {
			$msg = [];
			if (empty($password)) {
				$msg[] = "Введите пароль.";
			}
			if (empty($email)) {
				$msg[] = "Введите адрес почтового ящика.";
			}
			if (!App::$app->user->checkEmail($email) && !empty($email)) {
				$msg[] = "Введите правильный адрес почтового ящика.";
			}
			if (empty($name)) {
				$msg[] = "Введите имя.";
			}
			if (empty($surName)) {
				$msg[] = "Введите фамилию.";
			}
			if (App::$app->user->checkEmailExists($email)) {
				$msg[] = "Пользователь с таким e-mail уже существует<br>"
					. "Перейдите по ссылке, чтобы получить пароль на эту почту. <br>"
					. "<a href='" . PROJ . "/user/returnpass'>Забыли пароль</a>";
			}
			if ($msg) {//есть ошибки
				return $msg;
			}
		}
		return false;
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
		View::setMeta('Личный кабинет', 'Личный кабинет', '');
		View::setCss('cabinet.css');
		View::setJs('cabinet.js');
	}
	public function actionChangePassword()
	{
		$this->auth();
		View::setMeta('Личный кабинет', 'Личный кабинет', '');
		View::setCss('auth.css');
		View::setJs('auth.js');
	}

	public function actionReturnPass()
	{
		if ($data = $this->ajax) {
			$_SESSION['id'] = '';
			App::$app->user->returnPass($data['email']);
			$_SESSION["msg"] = 'Новый пароль проверьте на почте';
			exit('ok');
		}
		View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
		View::setJs('auth.js');
		View::setCss('auth.css');

	}

	public function actionLogin()
	{
		if ($data = $this->isAjax()) {
			$email = (string)$data['email'];
			$password = (string)$data['password'];

			if (!User::checkEmail($email)) {
				$msg[] = "Неверный формат email";
				$_SESSION['error'][] = "Неверный формат email";
				exit(include ROOT . '/app/view/User/alert.php');
			}

			if (!User::checkPassword($password)) {
				$msg[] = "Пароль не должен быть короче 6-ти символов";
				exit(include ROOT . '/app/view/User/alert.php');
			}

			$user = App::$app->user->findWhere("email", $email)[0];
			if (!$user) {
				$msg[] = "Пользователь с 'e-mail' : $email не зарегистрирован";
				$msg[] = "Перейдите в раздел <a href = '/user/register'>Регистрация</a> для регистрации.";
				exit(include ROOT . '/app/view/User/alert.php');

			} elseif (!(int)$user['confirm']) {
				$msg[] = 'зайдите на почту, с которой регистрировались.';
				$msg[] = 'найдите письмо "Регистрация VITEX".';
				$msg[] = 'перейдите по ссылке в письме.';
				exit(include ROOT . '/app/view/User/alert.php');

			} else {// Если данные правильные, запоминаем пользователя (в сессию)

				$user['rights'] = explode(",", $user['rights']);
				$this->setAuth($user);
				$this->set(compact('user'));
				header('Location: /user/cabinet');
//				$msg[] = "Все ок";
//				exit(include ROOT . '/app/view/User/alert.php');
			}
		}
		if (isset($_SESSION['id'])) {
			if ($user = App::$app->user->get($_SESSION['id'])) {
				$this->set(compact('user'));
			} else {
				$_SESSION['msg'] = 'Зарегистрируйтесь.';
				unset($_SESSION['id']);
			}
		}
		View::setJs('auth.js');
		View::setCss('auth.css');

	}

	public function actionEdit()
	{
		$this->auth();
		$user = App::$app->user->get($_SESSION['id']);
		if ($f = $this->ajax){
			foreach ($f as $key=>$value){
				if (array_key_exists($key, $user)){
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
