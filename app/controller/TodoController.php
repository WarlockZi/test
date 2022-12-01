<?php

namespace app\controller;

use app\model\Todo;

use app\view\components\CustomList\CustomList;
use app\view\Todo\TodoView;


class TodoController Extends AppController
{
	public $model = Todo::class;
	public $modelName = 'todo';

	public function __construct(array $route)
	{
		parent::__construct($route);

	}
	public function actionIndex()
	{
		$daily = Todo::where('type', 'daily')->get()->toArray();
		$daily = TodoView::daily($daily);
		$this->set(compact('daily'));

	}

	public function actionList()
	{
		$user_id = $this->user['id'];
		$items = $this->model::findAllWhere(['user_id'=>$user_id]);
		$daily = $this->getTable($items)->html;
		$this->set(compact('daily'));

		$items = $this->model::findAllWhere(['type'=>'месяц','user_id'=>$user_id]);
		$weekly = $this->getTable($items)->html;
		$this->set(compact('weekly'));

		$items = $this->model::findAllWhere(['type'=>'год','user_id'=>$user_id]);
		$yearly = $this->getTable($items)->html;
		$this->set(compact('yearly'));
	}

	public function actionShow()
	{
		$todos=Todo::findAll();
		$table = $this->getTable($todos);
		$this->set(compact('table'));
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			$this->ajax['user_id'] = $this->user['id'];
			$this->ajax['post_id'] = $this->user['post_id'];

			if ($id = $this->model::create($this->ajax)) {
				$this->exitJson([
					'id' => $id,
				]);
			}
		}
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			$this->exitWithPopup('ok' );
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';
	}

	private function getTable($items)
	{
		return new CustomList(

		);
	}

}
