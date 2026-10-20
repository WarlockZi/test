<?php

namespace app\controller;

use app\model\User;


class UserController extends AppController
{
    public string $model = User::class;

    public function __construct()
    {
        parent::__construct();
    }

//	public function actionIndex():void
//	{
//		Auth::getUser()->can();
//
//		$list = UserView::listAll();
//		$this->setVars(compact('list'));
//	}

//	public function actionEdit()
//	{
//		$item = $this->model::find($this->route['id']);
//		$item = UserView::getViewByRole($item, $this->user);
//
//		$this->setVars(compact('item'));
//
//		if ($user = $this->ajax) {
//			User::updateOrCreate($user);
//			response()->popup('Сохранено');
//		}
//	}


//	public function actionDelete():void
//	{
//		if ($data = $this->ajax) {
//			if ($user->can(['user_delete'])) {
//				User::delete($data['id']);
//				response()->popup('ok');
//			} else {
//				response()->popup('Не хватает прав');
//			}
//		}
//	}

}
