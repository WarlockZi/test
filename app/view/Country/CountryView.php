<?php

namespace app\view\Country;

use app\model\Country;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class CountryView
{

	public function __construct()
	{
	}

	public static function list($tags)
	{
		return MyList::build(Country::class)
			->pageTitle('Страны')
			->addButton('ajax')
			->items($tags->toArray())
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