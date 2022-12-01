<?php

namespace app\controller;

use app\core\Auth;
use app\model\User;
use app\view\User\UserView;


class UserController extends AppController
{
	public $model = User::class;
	public $modelName = 'user';


	public function __construct($route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		Auth::checkAuthorized($this->user, ['role_admin']);

		$list = UserView::listAll();
		$this->set(compact('list'));
	}

	public function actionChange()
	{
		$this->view = 'list';
		$users = User::findAll();
		$this->set(compact('users'));
	}

	public function actionEdit()
	{
		$item = $this->model::find($this->route['id']);
		$item = UserView::getViewByRole($item, $this->user);

		$this->set(compact('item'));

		if ($user = $this->ajax) {
			$user['id'] = $_SESSION['id'];
			User::updateOrCreate($user);
			$this->exitWithPopup('Сохранено');
		}
	}


	public function actionDelete()
	{
		if ($data = $this->ajax) {
			if (User::can($this->user, ['user_delete'])) {
				User::delete($data['id']);
				$this->exitWithPopup('ok');
			} else {
				$this->exitWithPopup('Не хватает прав');
			}
		}
	}

}
