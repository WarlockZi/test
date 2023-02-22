<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Route;
use app\model\Right;
use app\model\User;
use app\view\Right\RightView;



class RightController Extends AppController
{
	public $model = Right::class;
	public $modelName = 'right';
	public $tableName = 'rights';

	public function __construct()
	{
		parent::__construct();

	}
  public function actionUpdateOrCreate()
  {
    if ($this->ajax) {
      if ($id = Right::updateOrCreate($this->ajax)) {
        if (is_bool($id)) {
          $this->exitWithPopup('Сохранено');
        }else{
          $this->exitJson(['id'=>$id,'msg'=>'Создан']);
        }
      }
    }
  }

	public function actionIndex()
	{
		$list = RightView::listAll();
		$this->set(compact('list'));
	}

	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, ['right_delete']) || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWithPopup("ok");
			}
		}
		header('Location:/adminsc/right');
	}

}
