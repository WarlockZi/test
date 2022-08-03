<?php

namespace app\view\Product;

use app\model\Product;
use app\model\Illuminate\Product as IlluminateProduct;
use app\model\Property;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class ProductView
{

	public $modelName = Product::class;
	public $illuminateModel = IlluminateProduct::class;
	public $model = Product::class;

	public function __construct()
	{

	}
	public static function edit($id): string
	{
		$view = new self();
		$product = IlluminateProduct::with('category.parent_rec')
			->where('id', '=', $id)
			->get()[0];
		$product = $product->toArray();

		return ItemBuilder::build($view->illuminateModel, $id)
			->pageTitle('Редактировать товар :  ' . $product['name'])
			->field(
				ItemFieldBuilder::build('id')
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->required()
					->get()
			)
			->tab(
				ItemTabBuilder::build()
					->tabTitle('Свойства')
					->html(
						MyList::build(Property::class)
							->column(
								ListColumnBuilder::build('id')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->get()
							)
							->items($properties??[])
							->parent($view->modelName, $id)
							->edit()
							->addButton('ajax')
							->get()
					)
					->get()
			)
			->del()
			->save()
			->toList()
			->get();
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
//			->column(
//				ListColumnBuilder::build('title')
//					->name('Полное наим')
//					->contenteditable()
//					->search()
//					->width('1fr')
//					->get()
//			)
			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

	public static function card($slug)
	{
		$product = IlluminateProduct::
		with('properties','category','category.parent_rec')
			->where('slug', '=', $slug)
			->get()
			->toArray()[0];
		$product['nav'] = self::getNavigationStr($product['category']['parent_rec']);
		return $product;
	}

	protected static function getNavigationStr(array $arr,$str=''){
		$str = '/'.$arr['alias'];
		while ($arr['parent_rec']){
			$str.="/".$arr['parent_rec'];
			self::getNavigationStr($arr['parent_rec'],$str);
		}
		return $str;
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
