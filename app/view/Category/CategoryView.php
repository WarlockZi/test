<?php

namespace app\view\Category;

use app\core\Icon;
use app\model\Category;
use app\model\Product;
use app\model\Property;
use app\view\Builders\MorphBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

class CategoryView
{
	private $model = Category::class;
	private $modelName = 'category';
	public $html;

	public function __construct()
	{
	}

	public static function getBreadcrumb(array $category)
	{
		return "<a href='/adminsc/category/edit/{$category['id']}'>{$category['name']}</a>";
	}

	protected static function hasCat($cat)
	{
		return $cat['parent_recursive'];
	}

	protected static function getLastCategory(bool $isLink, $parents): string
	{
		return $isLink
			? "<li><a href='/adminsc/category/edit/{$parents['id']}'>{$parents['name']}</a></li>"
			: "<li><div>{$parents['name']}</div></li>";
	}

	protected static function getInitCategory(bool $isLink, $title, $href): string
	{
		return $isLink
			? "<li><a href='{$href}'>{$title}</a></li>"
			: "<li><div>{$title}</div></li>";
	}

	public static function breadcrumbs(int $id,
																		 bool $lastIsALink = false,
																		 bool $admin = true,
																		 string $class = 'breadcrumbs-1'): string
	{
		$prefix = $admin ? '/adminsc' : '';

		$parents =
			Category::with('parentRecursive.properties.vals')
				->find($id)->toArray();

		$arr = [];
		$finalCategory = self::getLastCategory($lastIsALink, $parents);
		while (self::hasCat($parents)) {
			$id = $parents['parent_recursive']['id'];
			$slug = $prefix ? "/edit/{$id}" : "/{$parents['parent_recursive']['slug']}";
			$name = $parents['parent_recursive']['name'];
			array_push($arr,
				"<li><a href={$prefix}/category{$slug}>{$name}</a></li>");
			$parents = $parents['parent_recursive'];
		}
		$initCategory = self::getInitCategory(true, 'Категории', "{$prefix}/category");
		array_push($arr, $initCategory);
		$arr = array_reverse($arr);
		array_push($arr, $finalCategory);
//		$breadcrumbs = implode('&nbsp;>&nbsp;', $arr);
		$breadcrumbs = implode('', $arr);
		return "<nav class='{$class}'>{$breadcrumbs}</nav>";
	}

	public static function edit($id): string
	{
		$view = new self();

		$illumCategory = Category::with(
			'products',
			'parentRecursive',
			'properties',
			'children',
			'mainImages')
			->find($id);
		$category = $illumCategory->toArray();

		return ItemBuilder::build($illumCategory, 'category')
			->pageTitle('Категория :  ' . $category['name'])
			->field(
				ItemFieldBuilder::build('id', $illumCategory)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $illumCategory)
					->name('Наименование')
					->contenteditable()
					->required()
					->get()
			)
			->field(
				ItemFieldBuilder::build('show_front', $illumCategory)
					->name('Показывать на главоной')
					->type('checkbox')
					->get()
			)
			->tab(
				ItemTabBuilder::build('Основная картинка')
					->html(


						MorphBuilder::build(
							$illumCategory,
							'Image',
							'main',
							'dnd'
						)
							->one($illumCategory->mainImages)
							->template('one.php')
							->detach('detach')
							->dnd(
								'one_dnd_plus.php',
								'holder',
								'dnd',
								'',
								Icon::plus(),
								'catalog',
								)
							->get()
					)
					->get()

			)
			->tab(
				ItemTabBuilder::build('Товары категории')
					->html(
						MyList::build(Product::class)
							->parent('category', $id)
							->addButton('ajax')
							->edit()
							->del()
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
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Св-ва категории')
					->html(
						MyList::build(Property::class)
							->items($illumCategory->properties->toArray() ?? [])
							->morph('category', $id)
//							->parent($view->modelName, $id)
							->edit()
							->del()
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
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Подкатегории')
					->html(
//						MyList::build(Category::class)
						MyList::build(Category::class)
							->edit()
							->del()
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
							->get()
					)
					->get()
			)
			->del()
			->save()
			->toList('', 'К списку категорий')
			->get();
	}

	public static function list($models): string
	{
		$view = new self($models);
		$table = $view->getList($models);
		$view->set(compact('table'));

		return $view->html;
	}

	private function getList($items)
	{
		return include ROOT . '/app/view/Category/list.php';
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