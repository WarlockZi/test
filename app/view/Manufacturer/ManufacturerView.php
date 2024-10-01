<?php

namespace app\view\Manufacturer;

use app\model\Manufacturer;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class ManufacturerView
{

	public function __construct()
	{
	}

	public static function list(string $modelName)
	{
		$items = $modelName::with('country')
			->get();
		return Table::build($items)
			->pageTitle('Поставщики')
			->addButton('ajax')
			->column(
				ColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->name('Наименование')
					->search()
					->contenteditable()
					->get()
			)
			->column(
				ColumnBuilder::build('country_id')
					->function(Manufacturer::class, 'countrySelect')
					->name('Страна')
					->get()
			)
			->del()
			->get();
	}


}