<?php

namespace app\controller;

use app\model\Right;
use app\model\User;
use app\view\View;
use app\view\components\CustomList\CustomList;


class RightController Extends AppController
{
	protected $model = Right::class;
	protected $modelName = 'right';
	protected $tableName = 'rights';

	public function __construct(array $route)
	{
		parent::__construct($route);
//		$rights = $this->model::findAll();
		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
	}

	public function actionList()
	{
		$this->view = 'list';

		$items = $this->model::findAll();
//		$this->set(compact('items'));
		$table = $this->getTable($items)->html;
		$this->set(compact('table'));

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
						'data-type'=>'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
//				'delCol' => false,
				'delCol' => 'ajax',
				'addButton'=> 'ajax',//'redirect'
			]
		);
	}

	public function actionShow()
	{
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
		}
	}


	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWith("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}


	public function actionUpdate()
	{
		if ($this->ajax) {
			$updated = $this->model::update($this->ajax);
			$this->exitWith('ok' );
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

	}
}
