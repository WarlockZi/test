<?php

namespace app\view\Property;

use app\model\Product;
use app\model\Property;
use app\model\Val;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;


class PropertyView
{
	public $modelName = Property::class;
	public $model = 'property';

	public static function index():string
	{
		return Table::build(Property::all())
            ->model('property')
			->column(
				ColumnBuilder::build('id')
					->width('50px')
					->name('Id')
					->get())
			->column(
				ColumnBuilder::build('name')
					->name('Название')
					->search()
					->sort()
					->contenteditable()
					->get()
			)->column(
				ColumnBuilder::build('show_as')
					->contenteditable()
					->name('Показывать как')
					->get()
			)
			->edit()
			->del()
			->addButton()
			->get();
	}


	public static function edit($id)
	{
		$view = new self();
		$prop = $view->modelName::with('categories', 'products', 'vals')->find($id);
		return ItemBuilder::build($prop, 'property')
			->pageTitle('Свойство : ' . $prop->name)
			->field(
				ItemFieldBuilder::build('id', $prop)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $prop)
					->name('Наименование')
					->contenteditable()
					->get()
			)
			->tab(
				ItemTabBuilder::build('Значения')
					->html(
						Table::build($prop->vals,)
							->relation('vals', 'value')
							->column(
								ColumnBuilder::build('id')
									->name('ID')
									->width('40px')
									->get()
							)
							->column(
								ColumnBuilder::build('name')
									->name('Наименование')
									->contenteditable()
									->width('1fr')
									->get()
							)
							->del()
							->addButton()
							->get()
					)
			)
			->tab(
				ItemTabBuilder::build('Принадлежит')
					->html(
						self::getMorphs($prop)
					)
			)
			->del()
			->save()
			->toList('adminsc/property/table')
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