<?php

namespace app\view\Supplier;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class SupplierView
{

	public function __construct()
	{
	}

	public static function list($modelName)
	{
		$items = $modelName::all();
		return MyList::build($modelName)
			->pageTitle('Поставщики')
			->addButton('ajax')
			->items($items->toArray())
			->column(
				ListColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->search()
					->contenteditable()
					->get()
			)
			->column(
				ListColumnBuilder::build('country_id')
					->name('Страна')
					->search()
					->contenteditable()
					->get()
			)
			->del()
			->get();


	}


}