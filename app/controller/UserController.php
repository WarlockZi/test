<?php

namespace app\controller;

use app\core\App;
use app\model\Right;
use app\model\User;
use app\view\components\CustomList\CustomList;
use app\view\View;


class UserController extends AppController
{
	protected $model = User::class;
	protected $modelName = 'user';
	protected $tableName = 'users';


	public function __construct($route)
	{
		parent::__construct($route);
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
		$this->autorize();
	}

	public function actionList()
	{
		$users = User::findAll();
		$this->set(compact('users'));

		$users_table = $this->usersTable($users)->html;
		$this->set(compact('users_table'));
	}

	private function usersTable($users)
	{
		return new CustomList(
			[
				'models' => $users,
				'modelName' => "user",
				'tableClassName' => 'users',
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type' => 'number',
						'sort' => true,
						'search' => false,
					],
					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'ФИО',
						'concat' => ['name', 'surName', 'middleName'],
						'width' => '1fr',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'email' => [
						'className' => 'email',
						'field' => 'email',
						'name' => 'email',
						'width' => '1fr',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'conf' => [
						'className' => 'conf',
						'field' => 'confirm',
						'name' => 'conf',
						'width' => '50px',
						'data-type' => 'string',
						'sort' => true,
						'search' => false,
					],
				],

				'editCol' => true,
				'delCol' => 'ajax',
				'addButton' => 'ajax',//'redirect'
			]
		);
	}

	public function actionShow()
	{
		if (!isset($_GET['id']) || !$id = $_GET['id']) {
			header('Location: /adminsc/user/list');
		};

		$user = User::findOneWhere('id', $id);
		$rights = Right::findAll();;

		$this->set(compact('user', 'rights'));
	}

	public function actionEdit()
	{
		$this->view = 'adminEdit';

		if (User::can($this->user, ['role_employee']) || defined('SU')) {
			if (isset($this->route['id'])) {
				$user = User::findOneWhere('id', $this->route['id']);
				$this->set(compact('user'));
			}

			$rights = App::$app->right->findAll();;
			$this->set(compact('rights'));
		} else {
			$this->layout = 'vitex';
			$this->view = 'edit';
		}
		if ($user = $this->ajax) {
			$user['id'] = $_SESSION['id'];
			User::update($user);
			exit('ok');
		}

//		View::setMeta('Профиль', 'Профиль', 'Профиль');
//		View::setJs('auth.js');
//		View::setCss('auth.css');
	}

	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
//			$date = strtotime($data['birthDate']);
//			$data['birthDate'] = date('Y-m-d', $date);
		}
	}

	public function actionDelete()
	{
		if ($data = $this->ajax) {
			if (User::can($this->user, 'user_delete')) {
				User::delete($data['id']);
				$this->exitWith('ok');
			}
		}
	}

	public function actionUpdate()
	{
		if ($data = $this->ajax) {
			$date = strtotime($data['birthDate']);
			$data['birthDate'] = date('Y-m-d', $date);

			User::update($data);
			exit('ok');
		}
	}

	public function actionContacts()
	{
		View::setMeta('Задайте вопрос', 'Задайте вопрос', 'Задайте вопрос');
	}

}
