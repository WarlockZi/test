<?php

namespace app\controller;

use app\core\Base\View;
use app\model\Mail;
use app\core\App;

//use app\model\User;
//use app\core\Base\Controller;
//use PHPMailer\PHPMailer\PHPMailer;

class UserController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);

	}

	public function actionContacts()
	{
		$this->auth();
		if (isset($_POST['token'])) {
			if ($_SESSION['token'] !== $_POST['token']) {
				echo $_POST['token'] . '  +  +  ' . $_SESSION['token'];
				exit('Обновите страницу.');
			}
		}
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}

	public function actionCabinet()
	{
		$this->auth(); // Авторизация

		if ($this->vars['user'] === false) {
			// Если пароль или почна неправильные - показываем ошибку
			$errors[] = 'Неправильные данные для входа на сайт';
		} elseif ($this->vars['user'] === NULL) {
			// Пароль почта в порядке, но нет подтверждения
			$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
		}
		View::setMeta('Личный кабинет', 'Личный кабинет', '');
		View::setCss(['css'=>'/public/build/cabinet.css']);
		View::setJs(['js'=>'/public/build/cabinet.js']);

	}

	public function actionLogin()
	{
		if ($data = $this->isAjax()) {
			$email = (string)$data['email'];
			$password = (string)$data['password'];

			if (!App::$app->user->checkEmail($email)) {
				$msg[] = "Неверный формат email";
				$_SESSION['error'][] = "Неверный формат email";
				exit(include ROOT . '/app/view/User/alert.php');
			}

			if (!App::$app->user->checkPassword($password)) {
				$msg[] = "Пароль не должен быть короче 6-ти символов";
				exit(include ROOT . '/app/view/User/alert.php');
			}

			$user = App::$app->user->getUserByEmail($email, $password);
			if ($user === false) { // Почта с паролем существуют, но нет подтверждения
				// Нет пользователя с таким паролем
				$msg[] = "Пользователь с 'e-mail' : $email не зарегистрирован";
				$msg[] = "Перейдите по <a href = 'https://vitexopt.ru" . "/user/register'>ССЫЛКЕ</a> чтобы зарегистрироваться.";
				exit(include ROOT . '/app/view/User/alert.php');

			} elseif ($user === NULL) {// Пароль, почта в порядке, но нет подтверждения
				$msg[] = 'Зайдите на <a href ="https://mail.vitexopt.ru/webmail/login/">РАБОЧУЮ ПОЧТУ</a>, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
				exit(include ROOT . '/app/view/User/alert.php');

			} else {// Если данные правильные, запоминаем пользователя (в сессию)
				$user['rights'] = explode(",", $user['rights']);
				App::$app->user->setAuth($user);

				$this->set(compact('user'));
				$msg[] = "Все ок";
				$_SESSION['id'] = $user['id'];
				exit(include ROOT . '/app/view/User/alert.php');
			}
		}
		if (isset($_SESSION['id'])) {
			$user = App::$app->user->getUser($_SESSION['id']);
			$this->set(compact('user'));
		}
		View::setJs(['js' => '/public/build/login.js', 'addtime']);
		View::setCss(['css' => '/public/build/login.css', 'addtime']);

	}


	public function actionRegister()
	{
		if ($data = $this->isAjax()) {

			$email = App::$app->user->clean_data($data['email']);

			if (App::$app->user->checkEmailExists($email)) {
				return;
			}

			$password = App::$app->user->clean_data($data['password']);
			$name = App::$app->user->clean_data($data['name']); //$post['reg_name'];//
			$surName = App::$app->user->clean_data($data['surName']); //$post['reg_name'];//
			$password = md5($password);
			$hash = md5(microtime());

			$sql = 'INSERT INTO users (rights, surName, name, email, password, hash)'
				. 'VALUES (?,?,?,?,?,?)';
			$params = [2, $surName, $name, $email, $password, $hash];

			App::$app->user->insertBySql($sql, $params);

			$headers = "Content-Type: text/plain; charset=utf8";
			$tema = "Регистрация VITEX";
			$mail_body = "Для продолжения работы перейдите по ссылке: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . "/user/confirm?hash=" . $hash;
			Mail::send_mail($email, $tema, $mail_body, $headers);

			$msg[] = "Для подтвержения регистрации перейдите по ссылке в <br><a href ='https://mail.vitexopt.ru/webmail/login/'>ПОЧТЕ</a>.<br>Письмо может попасть в папку 'Спам'";
			exit(include ROOT . '/app/view/User/alert.php');
		}


		View::setMeta('Регистрация', 'Регистрация', 'Регистрация');
		$token = $this->token;
		View::setCss(['css' => $this->route['controller'], 'view' => $this->view, 'addtime']);
		View::setJs(['js' => '/public/build/mainIndex.js', 'view' => $this->view, 'addtime']);
		$this->set(compact('token'));
	}

	public function send_mail($email, $tema, $mail_body, $headers)
	{

// Переменные, которые отправляет пользователь

		$text = $tema;

// Формирование самого письма
		$title = $tema;
		$body = <<< HERETEXT
<h2>Новое письмо $tema</h2>
<b>Имя:</b> dd<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$mail_body
HERETEXT;

// Настройки PHPMailer
		$mail = new PHPMailer();
		try {
			$mail->isSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;
			//$mail->SMTPDebug = 2;
			$mail->Debugoutput = function ($str, $level) {
				$GLOBALS['status'][] = $str;
			};

			// Настройки вашей почты
			$mail->Host = 'smtp.yandex.ru'; // SMTP сервера вашей почты
			$mail->Username = 'vvoronik@yandex.ru'; // Логин на почте
			$mail->Password = 'tExtile2002'; // Пароль на почте
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->setFrom('vvoronik@yandex.ru', 'Виталий'); // Адрес самой почты и имя отправителя

			// Получатель письма
			$mail->addAddress($email);

			// Прикрипление файлов к письму
			if (!empty($file['name'][0])) {
				for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
					$uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
					$filename = $file['name'][$ct];
					if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
						$mail->addAttachment($uploadfile, $filename);
						$rfile[] = "Файл $filename прикреплён";
					} else {
						$rfile[] = "Не удалось прикрепить файл $filename";
					}
				}
			}
// Отправка сообщения
			$mail->isHTML(true);
			$mail->Subject = $title;
			$mail->Body = $body;

// Проверяем отравленность сообщения
			if ($mail->send()) {
				$result = "success";
			} else {
				$result = "error";
			}

		} catch (Exception $e) {
			$result = "error";
			$status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
		}

// Отображение результата
		echo json_encode(["result" => $result]);
	}


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


			// Если есть пользователь с таким email.
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
		//очистить массив  $_SESSION
		$_SESSION = array();

		session_destroy();

		// Перенаправляем пользователя на главную страницу
		header("Location: /");
	}

	public function actionConfirm()
	{ // Забишем что пользователь подтвердил почту в базу данных
		// Получим id пользователя по hash
		try {
			$hash = App::$app->user->clean_data($_GET['hash']);
			if (!$hash) {
				throw new \Exception();
			}
		} catch (\Exception $e) {
			header('Location:/');
			exit();
		};

		if (!App::$app->user->confirm($hash)) {
			exit('Не удалось подтвердить почту');
		};
		$user = App::$app->user->getUserByHash($hash);
		// Сохраним id пользователя в сессии
		App::$app->user->setAuth($user);

		View::setMeta('Проверка почты', 'Почта пользователя проверена', 'проверка почты');

		$rightId = explode(",", $user['rights']);
		$js = $this->getJSCSS('.js');
		$this->set(compact('user', 'rightId'));

	}

	public function actionReturnPass()
	{
		$_SESSION['id'] = '';
		App::$app->user->returnPass();

		View::setMeta('Забыли пароль', 'Забыли пароль', 'Забыли пароль');
		$this->set(compact('user'));
	}

	public function actionEdit()
	{
		$this->auth(); // Авторизация $_SESSION['id']
		// Получаем идентификатор пользователя из сессии, если есть
		if (isset($_SESSION['id'])) {
			$userId = $_SESSION['id'];
		}
		// Получаем информацию о пользователе из БД
		$user = App::$app->user->getUser($userId);

		// Флаг результата
		$result = false;

		// Обработка формы
		if (isset($_POST['submit'])) { //нажали кнопку сохранить
			// Если форма отправлена
			// Получаем данные из формы редактирования

			$ff['table'] = 'users';
			$ff['pkey'] = 'id';
			$ff['pkeyVal'] = $user['id'];
			$ff['values']['email'] = App::$app->user->clean_data($_POST['email']);
			$ff['values']['name'] = App::$app->user->clean_data($_POST['name']);
			$ff['values']['surName'] = App::$app->user->clean_data($_POST['surName']);
			$ff['values']['middleName'] = App::$app->user->clean_data($_POST['middleName']);
			$ff['values']['birthDate'] = App::$app->user->clean_data($_POST['birthDate']);
			$ff['values']['phone'] = App::$app->user->clean_data($_POST['phone']);

			$errors = false;

			if (!App::$app->user->checkName(App::$app->user->clean_data($_POST['name']))) {
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}

			if ($errors == false) {
				// Если ошибок нет, сохраняет изменения профиля
				$result = App::$app->user->update($ff);
			}
			View::setMeta('Профиль', 'Профиль', 'Профиль');
//            $css = 'style.css';
//            $rightId = explode(",", $user['rights']);
			$this->set(compact('user', 'result', 'errors'));
		} else {// форма из базы данных
			$email = $user['email'];
			$name = $user['name'];
			$surName = $user['surName'];
			$middleName = $user['middleName'];
			$birthDate = $user['birthDate'];
			$phone = $user['phone'];
//            $password = $user['password'];

			View::setMeta('Профиль', 'Профиль', 'Профиль');
//         $rightId = explode(",", $user['rights']);
			$this->set(compact('user'));
		}
	}

}
