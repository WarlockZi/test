<?php

namespace app\controller;

use app\core\App;
use app\model\Mail;
use app\model\Post;
use app\model\User;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomMultiSelect\CustomMultiSelect;
use app\view\View;

class AuthController extends AppController
{
	protected $model = User::class;
	protected $modelName = 'user';
	protected $tableName = 'users';

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
			$found = User::findOneWhere('email', $user['email']);
			if ($found) exit('mail exists');

			$hash = md5(microtime());
			$user['password'] = $this->preparePassword($user['password']);
			$user['hash'] = $hash;


			$data['subject'] = "Регистрация VITEX";
			$data['to'] = [$user['email']];
			$href = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/auth/confirm?hash={$hash}";
			$data['body'] = $this->prepareBodyRegister($href, $hash);
			$data['altBody'] = "Подтверждение почты: <a href = '{$href}'>нажать сюда</a>>";

			try {
				if (!User::create($user)) {
					exit('registration failed');
				}
				$sent = Mail::send_mail($data);
				exit('confirm');
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}
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
		$user = User::findOneWhere('hash', $hash);
		if ($user) {
			$user['confirm'] = "1";
			if (User::update($user)) {
				$this->setAuth($user);
				header('Location:/auth/profile');
				$this->exitWith('"Вы успешно подтвердили свой E-mail."');
			}
		}
		header('Location:/auth/login');
		exit();
	}

	public function actionProfile()
	{
		$this->autorize();

//		$user = User::findOneWhere('id', $_SESSION['id']);
//		$posts = Post::findAll();
//		$multi = $this->getMultiselectPosts($posts, $user['post_id']);
//		$item = $this->getItem($user, $multi);
//		$this->set(compact('item'));

		$user = User::findOneWhere('id', $_SESSION['id']);
//		$posts = Post::findAll();
//		$multi = $this->getMultiselectPosts($posts, $user['post_id']);
//		$item = $this->getItem($user, $multi);
		$this->set(compact('user'));
		$this->view = 'profile1';

		if (User::can($this->user, 'role_employee'))
		{
			$this->layout = 'admin';
			View::setJs('admin.js');
			View::setCss('admin.css');
		}
		else {
			$this->layout = 'vitex';
		}
	}

	private function getMultiselectPosts($array, $selected=[])
	{
		return CustomMultiSelect::run([
			'className' => 'type1',
			'field' => 'post_id',
			'tab' => '.',
			'fieldName' => 'name',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
			'selected' => $selected,
		]);
	}

private function getItem($item, $posts)
{
	$item = new CustomCatalogItem(
		[
			'item' => $item,
			'modelName' => $this->modelName,
			'tableClassName' => $this->tableName,
			'fields' => [
				'id' => [
					'className' => 'id',
//						'field' => 'id',
					'name' => 'ID',
					'contenteditable' => '',
					'width' => '50px',
					'data-type' => 'number',
				],
				'name' => [
					'className' => 'name',
//						'field' => 'name',
					'name' => 'Имя',
					'width' => '1fr',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],
				'surName' => [
					'className' => 'surname',
//						'field' => 'surName',
					'name' => 'Фамилия',
					'width' => '1fr',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],
				'email' => [
					'className' => 'email',
//						'field' => 'email',
					'name' => 'email',
					'width' => '1fr',
					'contenteditable' => false,
					'data-type' => 'string',
				],

				'post_id' => [
					'className' => 'post',
//						'field' => 'post_id',
					'name' => 'Должности',
					'width' => '1fr',
					'data-type' => 'multiselect',
					'select' => $posts,
				],
			],

			'delBttn' => 'ajax',
			'toListBttn' => true,
			'saveBttn' => 'ajax',//'redirect'
		]
	);
	return $item->html;
}

public
function actionChangePassword()
{
	$this->autorize();
	if ($data = $this->ajax) {
		$old_password = $this->preparePassword($data['old_password']);

		if ($user = User::findOneWhere('password', $old_password)) {
			$user['password'] = $this->preparePassword($data['new_password']);
			User::update($user);
			exit('ok');
		}
		exit('fail');
	}
}

private
function randomPassword()
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

public
function actionReturnpass()
{
	if ($data = $this->ajax) {

		$_SESSION['id'] = '';
		$user = User::findOneWhere('email', $data['email']);

		if ($user) {
			$password = $this->randomPassword();
			$user['password'] = $this->preparePassword($password);
			User::update($user);

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

}


public
function actionLogin()
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

		$user = User::findOneWhere("email", $email);

		if (!$user) $this->exitWith('not_registered');
		if ($user['password'] !== $this->preparePassword($password)) $this->exitWith('wrong pass');// Если данные правильные, запоминаем пользователя (в сессию)
		$this->setAuth($user);
		if (User::can($user, 'role_employee')) {
			$this->exitWith('employee');
		} else {
			$this->exitWith('user');
		}
	}
}


}
