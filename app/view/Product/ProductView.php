<?php

namespace app\view\Product;

use app\model\Product;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\MyList\MyList;

class ProductView
{

	public $modelName = Product::class;

	public function __construct()
	{

	}

	public static function listItems(array $items): string
	{
		$view = new self;

		return MyList::build($view->modelName)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('title')
					->name('Полное наим')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->items($items)
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}


	public static function listAll(): string
	{
		$view = new self;
		return MyList::build($view->modelName)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('title')
					->name('Полное наим')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

	public static function belongToCategory($category)
	{

		$arr = $category->toArray();

		$str = '';
		foreach ($arr['products'] as $product) {

			$str .= "<div>{$product['name']}</div>";
		}
		return $str;

	}

}
