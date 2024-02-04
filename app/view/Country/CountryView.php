<?php

namespace app\view\Country;

use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class CountryView
{

	public function __construct()
	{
	}

	public static function list(string $className)
	{
    $countries = $className::all();
		return MyList::build($className)
			->pageTitle('Страны')
			->addButton('ajax')
			->all()
			->column(
				ListColumnBuilder::build('id')
					->width('50px')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->search()
					->contenteditable()
					->get()
			)
			->del()
			->get();


	}


}