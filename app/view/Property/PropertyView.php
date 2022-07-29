<?php

namespace app\view\Property;

use app\model\Property;
use app\model\Val;
use app\view\components\Builders\Item\ItemFieldBuilder;
use app\view\components\Builders\Item\ItemTabBuilder;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\MyItem\MyItem;
use app\view\components\MyList\MyList;
use app\view\MyView;

class PropertyView extends MyView
{
	public $modelName = Property::class;
	public $model = 'property';
	public $html;

	public static function listAll()
	{
		$view = new self;
		return MyList::build($view->modelName)
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
			->del()
			->addButton('ajax')
			->get();
	}


	public static function edit($id)
	{
		$view = new self();
		return MyItem::build($view->modelName, $id)
			->field(
				ItemFieldBuilder::build('id')
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->tab(
				ItemTabBuilder::build()
					->tabTitle('Значения')
					->html(
						MyList::build(Val::class)
							->items(Val::findAllWhere('property_id', $id))
							->parent($view->model, $id)
							->column(
								ListColumnBuilder::build('id')
									->name('ID')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name('Наименование')
									->contenteditable()
									->width('1fr')
									->get()
							)
							->del()
							->addButton('ajax')
							->get()
					)
					->get()
			)
			->pageTitle('Свойство')
			->del()
			->save()
			->toList()
			->get();

	}



}