<?php


namespace app\view\Val;


use app\model\Property;
use app\model\Val;
use app\view\components\CustomList\CustomList;
use app\view\components\MyList\MyList;
use app\view\MyView;


class ValView extends MyView
{
	static $modelName = Val::class;
	public $model = '';
	public $html;

	public function __construct()
	{
		parent::__construct();
		$this->model = new self::$modelName;
	}

	public static function listBelongsTo($model,$id)
	{
		$valView = new static();
		$items = Val::where($model->model.'_id', '=',$id)
			->get();
		return MyList::create(self::$modelName)
			->column([
					'field' => 'id',
					'name' => 'ID',
					'type' => 'number',
					'sort' => true,
					'search' => false,
					'width' => '50px',
					'contenteditable' => false,
				]
			)->column([
				'field' => 'name',
				'name' => 'Значение',
				'type' => 'string',
				'sort' => true,
				'search' => true,
				'width' => '1fr',
				'contenteditable' => true,
			])->addButton('ajax')
			->del()
//			->edit()
			->items($items)
			->parent($model,$id)
			->get();

	}

	protected function getList()
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