<?php

namespace app\view\Category;

use app\model\Category;
use app\model\Product;
use app\model\Property;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;

class CategoryView
{
	public static function edit($id): string
	{
		$category = Category::with(
			'products',
			'parentRecursive',
			'properties',
			'mainImages')
			->find($id);

		return ItemBuilder::build($category, 'category')
			->pageTitle('Категория :  ' . $category->name)
			->field(
				ItemFieldBuilder::build('id', $category)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $category)
					->name('Наименование')
					->contenteditable()
					->required()
					->get()
			)
			->field(
				ItemFieldBuilder::build('show_front', $category)
					->name('Показывать на главоной')
					->html(
						CheckboxBuilder::build('show_front',
							$category->show_front)
							->get()
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('categiry_id', $category)
					->name('Принадлежит')
					->html(
						SelectBuilder::build()
							->initialOption('',0)
							->selected($category->category_id)
							->tree(Category::all(),'children')
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Основная картинка')
					->html(

						MorphBuilder::build($category, 'image', true, 'mainImages')
							->class('dnd')
							->template('many.php')
							->content(
								DndBuilder::build('category', 'holder')
									->get()
							)
//							->dnd('dnd',
//								'dnd','dnd',
//								'перетащить картинку',
//								Icon::plus(),'category')
							->get()

//						DndBuilder::build('catalog', 'dnd')
//							->morph($category, 'mainImages', 'image', 0,
//								true, 'one',
//								'main', 'holder')
//							->get()

					)
					->get()

			)
			->tab(
				ItemTabBuilder::build('Товары категории')
					->html(
						MyList::build(Product::class)
							->belongsTo('category', $id)
							->addButton('ajax')
							->items($category['products'] ?? [])
							->column(
								ListColumnBuilder::build('id')
									->width("40px")
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name("Название")
									->get()
							)
							->column(
								ListColumnBuilder::build('slug')
									->name("Назв. на сайте")
									->get()
							)
							->edit()
							->del()
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Св-ва категории')
					->html(
						MyList::build(Property::class)
							->items($category->properties ?? [])
							->morph('category', $id, 'many', false)
							->addButton('ajax')
							->column(
								ListColumnBuilder::build('id')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name("Назввание")
									->contenteditable()
									->get()
							)
							->edit()
							->del()
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Подкатегории')
					->html(

						MyList::build(Category::class)
							->addButton('ajax')
							->items($category['children'] ?? [])
							->column(
								ListColumnBuilder::build('id')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name("Назввание")
									->contenteditable()
									->get()
							)
							->belongsTo('category', $id)
							->edit()
							->del()
							->get()

					)
					->get()
			)
			->del()
			->save()
			->toList('', 'К списку категорий')
			->get();
	}

	public static function list(): string
	{
		return MyList::build(Category::class,10)
			->column(
				ListColumnBuilder::build('id')
					->get()
			)->column(
				ListColumnBuilder::build('name')
					->get()
			)
			->edit()
			->get();
	}


	public static function selector(int $selected, int $exclude = -1): string
	{
		$cats = Category::all()->toArray();
		$parent_select = '<select>';
		$parent_select .= "<option value=0>---</option>";
		foreach ($cats as $t) {
			if ((int)$t['id'] !== $exclude) {
				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
				$parent_select .= "<option value={$t['id']} {$selectedStr}>{$t['name']}</option>";
			}
		}
		$parent_select .= "</select>";

		return $parent_select;
	}

}