<?php

namespace app\view\Supplier;

use app\model\Country;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class SupplierView
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
					->html(SupplierView::countrySelector($items))
					->get()
			)
			->del()
			->get();
	}

	protected static function countrySelector($supplier){
		$county =  SelectBuilder::build()
			->field('country_id')
			->model('country')
			->nameOptionByField('name')
			->initialOption('',0)
			->tree(Country::all()->toArray())
			->selected($supplier[0]['country_id'] ?? 0)
			->get();
		return $county;
	}

	protected function countryColumn(){
		return ListColumnBuilder::build('country_id')
			->name('Страна')
			->search()
			->contenteditable()
			->get();
	}

}