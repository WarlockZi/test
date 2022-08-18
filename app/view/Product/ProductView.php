<?php

namespace app\view\Product;

use app\model\Illuminate\Category as IlluminateCategory;
use app\model\Illuminate\Product as IlluminateProduct;
use app\model\Product;
use app\model\Property;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class ProductView
{

	public $illuminateModel = IlluminateProduct::class;
	public $modelName = Product::class;
	public $model = 'product';

	public static function edit($id): string
	{
		$product = IlluminateProduct::with('category.properties', 'category.category_recursive.properties')
			->find($id);

		return ItemBuilder::build($product, 'product')
			->pageTitle('Товар :  ' . $product['name'])
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
						self::getProperties($product)
					)
					->get()
			)
			->del()
			->save()
			->toList()
			->get();
	}

	public static function getProperties($product): string
	{
		$properties = $product->category->properties;

		$str = "{$product->category->name}<br>";
		foreach ($properties as $property) {
			$vals = self::prepareVals($property->vals->toArray());
			$str .= "{$property->name}: " .
				SelectBuilder::build()
					->array($vals)
					->initialOption('', 0)
					->get();
		}
		$recProps = self::getProperyRecursiveProps($product);
		return $str;
	}

	protected static function prepareVals($vals)
	{
		$arr = [];
		foreach ($vals as $val) {
			$arr[$val['id']] = $val['name'];
		}
		return $arr;
	}

	protected static function hasCat($cat)
	{
		return $cat['category_recursive'];
	}

	protected static function getProperyRecursiveProps($product)
	{
		$parents = $product->category->category_recursive
			->toArray();

		while (self::hasCat($parents)) {

			$arr[] = $parents['properties'];
			$parents = $parents['category_recursive'];
		}
		return $arr;
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
		with('properties', 'category', 'category.category_recursive')
			->where('slug', '=', $slug)
			->get()
			->toArray()[0];
		$product['nav'] = self::getNavigationStr($product['category']['category_recursive']);
		return $product;
	}

	protected static function getNavigationStr(array $arr, $str = '')
	{
		$str = '/' . $arr['alias'];
		while ($arr['category_recursive']) {
			$str .= "/" . $arr['category_recursive'];
			self::getNavigationStr($arr['category_recursive'], $str);
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
