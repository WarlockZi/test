<?php

namespace app\view\Product;

use app\model\Illuminate\Product as IlluminateProduct;
use app\model\Product;
use app\model\Property;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class ProductView
{

	public $illuminateModel = IlluminateProduct::class;
	public $modelName = Product::class;
	public $model = 'product';

	public static function edit($id): string
	{
		$view = new self();
		$product = IlluminateProduct::with('category')
			->find($id);
		$properties = $product->category->properties->toArray();
		$categoryId = $product->category->id;


		return ItemBuilder::build($product, 'product')
			->pageTitle('Редактировать товар :  ' . $product['name'])
			->field(
				ItemFieldBuilder::build('id', $product)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $product)
					->name('Наименование')
					->contenteditable()
					->required()
					->get()
			)
			->tab(
				ItemTabBuilder::build('Свойства товара')
					->html(
						MyList::build(Property::class)
							->column(
								ListColumnBuilder::build('id')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name('Свойство')
									->search()
									->sort()
									->get()
							)
							->column(
								ListColumnBuilder::build('')
									->name('Значения')
									->html('')
								->get()
							)

							->items($properties ?? [])
							->morph('category', $categoryId)
//							->edit()
//							->del()
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
			->pageTitle('Товары')
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

			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

	public static function card($slug)
	{
		$product = IlluminateProduct::
		with('properties', 'category', 'category.parent_rec')
			->where('slug', '=', $slug)
			->get()
			->toArray()[0];
		$product['nav'] = self::getNavigationStr($product['category']['parent_rec']);
		return $product;
	}

	protected static function getNavigationStr(array $arr, $str = '')
	{
		$str = '/' . $arr['alias'];
		while ($arr['parent_rec']) {
			$str .= "/" . $arr['parent_rec'];
			self::getNavigationStr($arr['parent_rec'], $str);
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
