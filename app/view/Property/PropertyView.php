<?php

namespace app\view\Property;

use app\model\Property;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\MyList\MyList;
use app\view\MyView;
use app\view\Val\ValView;

class PropertyView extends MyView
{
	public $model = Property::class;
	public $html;

	public static function listAll()
	{
		$view = new self;
		return MyList::build($view->model)
			->all()
			->column(
				ListColumnBuilder::build('id')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->get()
			)->column(
				ListColumnBuilder::build('description')
					->get()
			)
			->edit()
			->addButton('ajax')
			->get();
	}


	public static function edit($id)
	{
		$view = new self();

		$item = $view->model::where('id', '=', $id)->get()[0];
		$view->getItem($item);
		$item = $view->html;

		return [$item];
	}


	private function getItem($item): void
	{

		$view = new static();
		$this->model = new $view->model;
		$options = $this->getOptions($item);

		$t = new CustomCatalogItem($options);
		$this->html = $t->html;
	}


	private function getOptions(array $item)
	{

		return [
			'item' => $item,
			'modelName' => $this->model->model,
			'tableClassName' => $this->model->table,
			'pageTitle' => '',
			'tabs' => [
				['title' => 'Значения',
					'html' => ValView::listBelongsTo($this->model, $item['id']),
				],
			],
			'fields' => [
				'ID' => [
					'field' => 'id',
					'contenteditable' => false,
				],
				'Имя' => [
					'field' => 'name',
					'contenteditable' => true,
					'required' => true,
				],

			],
			'delBttn' => true,
			'saveBttn' => true,

		];
	}

}