<?php

namespace app\controller\Admin;

use app\model\Right;
use app\view\Right\RightView;


class RightController extends AdminscController
{
    public string $model = Right::class;
//	public $modelName = 'right';
//	public $tableName = 'rights';

    public function __construct()
    {
        parent::__construct();

    }

    public function actionIndex(): void
    {
        $list = RightView::listAll();
        $this->setVars(compact('list'));
    }

//	public function actionDelete():void
//	{
//		$id = $this->ajax['id']??$_POST['id'];
//		if ($user->can(['right_delete']) || defined(SU)) {
//			if ($this->model::delete($id)) {
//				Response::exitWithPopup("ok");
//			}
//		}
//		header('Location:/adminsc/right');
//	}

}
