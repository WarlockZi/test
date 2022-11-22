<?php


namespace app\view\Val;


use app\model\Val;
use app\view\components\CustomList\CustomList;
use app\view\MyView;


class ValView extends MyView
{
	static $modelName = Val::class;
	public $model = 'val';
	public $html;

	public function __construct()
	{
		parent::__construct();
		$this->model = new self::$modelName;
	}

	public function getList()
	{
		return new CustomList(
			[
				'models' => $this->items,
				'parent' => $this->model->model,
				'modelName' => $this->model->model,
				'tableClassName' => $this->model->table,
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
					'property_id' => [
						'className' => 'description',
						'field' => 'property_id',
						'name' => 'родитель',
						'width' => '50px',
						'contenteditable' => '',
						'data-type' => 'string',
						'sort' => false,
						'search' => false,
					],
				],
				'editCol' => false,
				'delCol' => true,
				'addButton' => 'ajax'
			]
		);
	}

}