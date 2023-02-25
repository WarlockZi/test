<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Todo;
use app\view\components\CustomList\CustomList;
use app\view\Planning\PlanningView;

class PlanningController Extends AppController
{
//	public $modelName = Todo::class;
//	public $model = 'todo';

	public function __construct()
	{
		parent::__construct();
	}


	public function actionCreate()
	{
		$items = Todo::where('type', 'день')->
		where('user_id', $this->user['id'])->
		get();
		$daily = PlanningView::list($items);
		$this->set(compact('daily'));
	}

	private function getTable($items)
	{
		return new CustomList(
			[
				'models' => $items,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type' => 'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
//				'delCol' => false,
				'delCol' => 'ajax',
				'addButton' => 'ajax',//'redirect'
			]
		);
	}

	public function actionIndex()
	{

	}

}
