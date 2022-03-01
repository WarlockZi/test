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

	public function actionUsers()
	{

		$this->auth();
		$users = App::$app->user->findAll('users');
		$this->set(compact('users'));
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionShow()
	{
		if (!isset($_GET['id']) || !$id = $_GET['id']) {
			header('Location: /adminsc/user/users');
		};

		$user = App::$app->user->findOne($id);
		$rights = App::$app->right->findAll();;

		$this->set(compact('user', 'rights'));
	}


	public function actionEdit()
	{
		$this->autorize();
		$user = App::$app->user->findOne($_SESSION['id']);
		if ($data = $this->ajax) {

			$user['name'] = $data['name'];
			$user['sex'] = $data['sex'];
			$user['surName'] = $data['surName'];
			$user['middleName'] = $data['middleName'];
			$user['rights'] = implode(',', $user['rights']);

			$date = strtotime($data['birthDate']);
			$user['birthDate'] = date('Y-m-d', $date);

			$user['phone'] = $data['phone'];

			App::$app->user->update($user);
			exit('ok');

		}
		$this->set(compact('user'));

		View::setMeta('Профиль', 'Профиль', 'Профиль');
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	public function actionContacts()
	{
		$this->autorize();
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}

	public function actionUpdate()
	{
		$this->autorize();
		if ($data = $this->ajax) {
			$date = strtotime($data['birthDate']);
			$data['birthDate'] = date('Y-m-d', $date);

			App::$app->user->update($data);
			exit('ok');
		}
	}


}
