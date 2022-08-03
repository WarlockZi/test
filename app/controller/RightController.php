<?php

namespace app\controller;

use app\model\Right;
use app\model\User;
use app\view\Right\RightView;
//use app\view\View;


class RightController Extends AppController
{
	protected $model = Right::class;
	protected $modelName = 'right';
	protected $tableName = 'rights';

	public function __construct(array $route)
	{
		parent::__construct($route);

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

	public function actionList()
	{
		$list = RightView::listAll();
		$this->set(compact('list'));
	}

	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWithPopup("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}

}
