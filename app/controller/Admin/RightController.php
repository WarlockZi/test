<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\model\Right;
use app\model\User;
use app\view\Right\RightView;



class RightController Extends AppController
{
	public string $model = Right::class;
	public $modelName = 'right';
	public $tableName = 'rights';

	public function __construct()
	{
		parent::__construct();

	}
  public function actionUpdateOrCreate(): void
  {
    if ($this->ajax) {
      if ($id = Right::updateOrCreate($this->ajax)) {
        if (is_bool($id)) {
          Response::exitWithPopup('Сохранено');
        }else{
          Response::exitJson(['id'=>$id,'msg'=>'Создан']);
        }
      }
    }
  }

	public function actionIndex():void
	{
		$list = RightView::listAll();
		$this->set(compact('list'));
	}

	public function actionDelete():void
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, ['right_delete']) || defined(SU)) {
			if ($this->model::delete($id)) {
				Response::exitWithPopup("ok");
			}
		}
		header('Location:/adminsc/right');
	}

}
