<?php

namespace app\view\Country;

use app\model\Country;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class CountryView
{

	public function __construct()
	{
	}

	public static function list(string $className)
	{
		return Table::build(Country::all())
			->pageTitle('Страны')
            ->model('country')
			->addButton()
			->column(
				ColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ColumnBuilder::build('name')
					->search()
					->contenteditable()
					->get()
			)
			->del()
			->get();


	}


}