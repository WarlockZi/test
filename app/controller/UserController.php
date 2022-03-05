<?php

namespace app\controller;

use app\core\App;
use app\view\View;


class UserController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionList()
	{
		$this->auth();
		$users = App::$app->user->findAll('users');
		$this->set(compact('users'));
	}

	public function actionShow()
	{
		if (!isset($_GET['id']) || !$id = $_GET['id']) {
			header('Location: /adminsc/user/list');
		};

		$user = App::$app->user->findOne($id);
		$rights = App::$app->right->findAll();;

		$this->set(compact('user', 'rights'));
	}

	public function actionEdit()
	{
		$this->autorize();

		if (array_intersect(['role_employee'], $this->user['rights']) || defined('SU')) {
			if (isset($this->route['id'])) {
				$user = App::$app->user->findOne($this->route['id']);
				$this->set(compact('user'));
			}
			$this->view = 'adminEdit';


			$rights = App::$app->right->findAll();;
			$this->set(compact('rights'));
		} else {
			$this->layout = 'vitex';
			$this->view = 'edit';

		}
		if ($user = $this->ajax) {
			$user['id'] = $_SESSION['id'];
			App::$app->user->update($user);
			exit('ok');
		}

		View::setMeta('Профиль', 'Профиль', 'Профиль');
		View::setJs('auth.js');
		View::setCss('auth.css');
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
	public function actionCabinet()
	{
		$this->autorize();
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}
	public function actionContacts()
	{
		$this->autorize();
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}

}
