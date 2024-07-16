<?php

namespace app\view\Property;

use app\model\Product;
use app\model\Property;
use app\model\Val;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;


class PropertyView
{
	public $modelName = Property::class;
	public $model = 'property';

	public static function listAll()
	{
		$view = new self;
		return MyList::build($view->modelName)
			->all()
			->column(
				ListColumnBuilder::build('id')
					->width('50px')
					->name('Id')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Название')
					->search()
					->sort()
					->contenteditable()
					->get()
			)->column(
				ListColumnBuilder::build('show_as')
					->contenteditable()
					->name('Показывать как')
					->get()
			)
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}


	public static function edit($id)
	{
		$view = new self();
		$item = $view->modelName::with('categories', 'products', 'vals')->find($id);
		return ItemBuilder::build($item, 'property')
			->pageTitle('Свойство : ' . $item->name)
			->field(
				ItemFieldBuilder::build('id', $item)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $item)
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->tab(
				ItemTabBuilder::build('Значения')
					->html(
						MyList::build(Val::class)
							->items($item->vals)
							->relation('vals')
							->column(
								ListColumnBuilder::build('id')
									->name('ID')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name('Наименование')
									->contenteditable()
									->width('1fr')
									->get()
							)
							->del()
							->addButton('ajax')
							->get()
					)
			)
			->tab(
				ItemTabBuilder::build('Принадлежит')
					->html(
						self::getMorphs($item)
					)
			)
			->del()
			->save()
			->toList('adminsc/property/list')
			->get();

	}

	public static function getProductSelector(Property $property, Product $product)
	{
		$intersect = $property->vals->intersect($product->values);
		$selected = $intersect->count() ? $intersect[0]->id : 0;
		$options = ArrayOptionsBuilder::build($property->vals)
			->initialOption()
			->selected($selected)
			->get();

		$select = MorphBuilder::build($product, 'values', 'prop-' . $property->id)
			->html(SelectBuilder::build($options)->get())
			->model('val')
			->get();

		$propName = "<div class='property'>{$property->name}</div>";
		$valueSelector = "<div class='value'>{$select}</div>";
		return "<div class='row'>{$propName}{$valueSelector}</div>";
	}

	protected static function getMorphs($item)
	{
		$categories = $item->categories->toArray();
		$products = $item->products->toArray();
		$categoriesHtml = '';
		foreach ($categories as $category) {
			$categoriesHtml .= "<a href='/adminsc/category/edit/{$category['id']}'>Категория {$category['name']}</a>";
		}
		$productsHtml = '';
		foreach ($products as $product) {
			$productsHtml .= "<a href='/adminsc/product/edit/{$product['id']}'>Товар {$product['name']}</a>";
		}

		return $categoriesHtml . $productsHtml;
	}

}