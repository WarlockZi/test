<?php

namespace app\controller;

use app\model\illuminate\User as illuminateUser;
use app\model\User;
use app\view\User\UserView;


class UserController extends AppController
{
	protected $illuminateModel = illuminateUser::class;
	protected $model = User::class;
	public $modelName = 'user';


	public function __construct($route)
	{
		parent::__construct($route);

	}

	public function actionList()
	{
		$list = UserView::listAll();
		$this->set(compact('list'));
	}

	public function actionChange()
	{
		$this->view = 'list';
		$users = User::findAll();
		$this->set(compact('users'));

		$users_table = include ROOT . '/app/view/User/del___getList.php';
		$this->set(compact('users_table'));
	}


	public function actionEdit()
	{
		$user = $this->illuminateModel::find($this->route['id']);

		if (!$user) {
			$item = UserView::noElement();
		} else {
			if (User::can($this->user, ['role_employee'])) {
				if (User::can($this->user, ['role_admin'])) {
					$userr = $user->toArray();
					$userr['rights'] = explode(',', $userr['rights']);
					$tab = UserView::getAdminTab($userr);
					$item = UserView::admin($user, $tab);
				} else {
					$item = UserView::employee($user);
				}
			} else {
				$item = UserView::guest($user);
			}
		}
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
			if (User::can($this->user, 'user_delete')) {
				User::delete($data['id']);
				$this->exitWithPopup('ok');
			} else {
				$this->exitWithPopup('Не хватает прав');
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			if ($id = User::updateOrCreate($this->ajax)) {
				if (is_bool($id)) {
					$this->exitWithPopup('Сохранено');
				} else {
					$this->exitJson(['id' => $id, 'msg' => 'Создан']);
				}
			}
		}
	}
//
//	public function actionUpdate()
//	{
//		if ($data = $this->ajax) {
//			$date = strtotime($data['birthDate']);
//			$data['birthDate'] = date('Y-m-d', $date);
//
//			User::update($data);
//			$this->exitWithPopup('ok');
//		}
//	}

//
//
//	public function actionCreate()
//	{
//		if ($user = $this->ajax) {
//			$user['password'] = $this->preparePassword('gfasdf41(D{%)');
//			if ($id = $this->model::create($this->ajax)) {
//				exit(json_encode([
//					'id' => $id,
//				]));
//			}
//		}
//	}
//	public function actionShow()
//	{
//		$rights = Right::findAll();
//		$this->set(compact('rights'));
//
//		$item = new User();
//		$item = include ROOT . '/app/view/User/getItem.php';
//		$this->set(compact('item'));
//		$this->set(compact('rights'));
//
//	}

}
