<?php

namespace app\view\Manufacturer;

use app\model\Manufacturer;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class ManufacturerView
{

	public function __construct()
	{
	}

	public static function list(string $modelName)
	{
		$items = $modelName::with('country')
			->get();
		return MyList::build($modelName)
			->pageTitle('Поставщики')
			->addButton('ajax')
			->items($items)
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
//					->html(
//
//					)
					->function(Manufacturer::class, 'countrySelect')
					->name('Страна')
					->get()
			)
			->del()
			->get();
	}


}