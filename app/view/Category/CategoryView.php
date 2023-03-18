<?php

namespace app\view\Category;

use app\model\Category;
use app\model\Product;
use app\model\Property;
use app\Repository\CategoryRepository;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\TreeABuilder;
use app\view\Image\ImageView;

class CategoryView
{

	public static function indexTree($categoriesTree)
	{
		return TreeABuilder::build(
			$categoriesTree, 'children_recursive', 2)
			->href('/adminsc/category/edit/')
			->get();
	}

	public static function edit(?int $id): string
	{

		$category = CategoryRepository::edit($id);

		return ItemBuilder::build($category, 'category')
			->pageTitle('Категория :  ' . $category->name)
			->field(
				ItemFieldBuilder::build('id', $category)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('slug', $category)
					->name('Адрес')
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
						CategoryRepository::selector($category->category_id, $category->id)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Основная картинка')
					->html(
						MorphBuilder::build($category, 'mainImages', 'main')
							->html(DndBuilder::make('category'))
							->html(ImageView::morphImages($category, 'mainImages'))
							->get()
					)
			)
			->tab(
				ItemTabBuilder::build('Товары категории')
					->html(
						MyList::build(Product::class)
							->pageTitle('Товары категории')
							->realtion('products')
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
			)
			->tab(
				ItemTabBuilder::build('Св-ва категории')
					->html(
						MorphBuilder::build($category, 'properties', 'prop', true)
							->many()
							->html(
								MyList::build(Property::class)
									->items($category->properties ?? [])
									->pageTitle('Св-ва категории')
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
									->get())
							->get()
					)
			)
			->tab(
				ItemTabBuilder::build('Подкатегории')
					->html(
						MyList::build(Category::class)
							->pageTitle('Подкатегории')
							->items($category['childrenNotDeleted'] ?? [])
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
							->realtion('childrenNotDeleted')
							->edit()
							->del()
							->addButton('ajax')
							->get()
					)
			)
			->tab(
				ItemTabBuilder::build('Удаленные Подкатегории')
					->html(
						MyList::build(Category::class)
							->pageTitle('Удаленные подкатегории')
							->items($category['childrenDeleted'] ?? [])
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
							->realtion('childrenDeleted')
							->edit()
							->del()
							->addButton('ajax')
							->get()
					)
			)
//			->del()
			->softDel()
			->toList('', 'К списку категорий')
			->get();
	}

	public static function list(): string
	{
		return MyList::build(Category::class, 10)
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

	public static function getMainImage(Category $category)
	{
		if ($category->mainImages->count()){
			ImageView::catMainImage($category->mainImages->first());
		}else{
			return ImageView::noImage();
		}

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