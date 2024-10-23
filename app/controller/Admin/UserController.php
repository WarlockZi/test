<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\core\Response;
use app\model\User;
use app\view\User\UserView;


class UserController extends AppController
{
	public string $model = User::class;
	public $modelName = 'user';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{
		$list = UserView::listAll();
		$this->setVars(compact('list'));
	}


	public function actionEdit(): void
    {
		$item = $this->model::find($this->route->id);
		$item = UserView::getViewByRole($item, Auth::getUser());

		$this->setVars(compact('item'));

		if ($user = $this->ajax) {
			$user['id'] = $_SESSION['id'];
			User::updateOrCreate($user);
			Response::exitWithPopup('Сохранено');
		}
	}


	public function actionDelete():void
	{
		if ($data = $this->ajax) {
			if ($user->can(['user_delete'])) {
				User::delete($data['id']);
				Response::exitWithPopup('ok');
			} else {
				Response::exitWithPopup('Не хватает прав');
			}
		}
	}

}
