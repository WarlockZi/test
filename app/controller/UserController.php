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
	public $modelName = 'user';
	public $tableName = 'users';


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

		$users_table = include ROOT . '/app/view/User/getList.php';
		$this->set(compact('users_table'));
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

		if (User::can($this->user, ['role_employee'])) {
			if (isset($this->route['id'])) {
				$user = User::findOneWhere('id', $this->route['id']);
				$this->set(compact('user'));
			}
			$rights = Right::findAll();
			$this->set(compact('rights'));

			$item = $user;
			$item = include ROOT . '/app/view/User/getItem.php';
			$this->set(compact('item'));

		}
		if ($user = $this->ajax) {
			$user['id'] = $_SESSION['id'];
			User::update($user);
			exit('ok');
		}
	}

	public function actionCreate()
	{
		if ($user = $this->ajax) {
			$user['password'] = $this->preparePassword('gfasdf41(D{%)');
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
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
			$this->exitWith('ok');
		}
	}


}
