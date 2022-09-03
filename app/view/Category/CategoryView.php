<?php

namespace app\view\Category;

use app\model\Category;
use app\model\Illuminate\Category as IlluminateCategory;
use app\model\Product;
use app\model\Property;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use Illuminate\Database\Eloquent\Model;

class CategoryView
{
	private $model = IlluminateCategory::class;
	private $modelName = 'category';
	public $html;

	public function __construct()
	{
	}

	protected static function getBreadcrumb(array $category)
	{
		return "<a href='/adminsc/category/edit/{$category['id']}'>{$category['name']}</a>";
	}

	protected static function hasCat($cat)
	{
		return $cat['category_recursive'];
	}

	protected static function getLast(bool $isLink, $parents):string
	{
		return $isLink
			?"<a href='/adminsc/category/edit/{$parents['id']}'>{$parents['name']}</a>"
			:"<div>{$parents['name']}</div>";
	}

	public static function breadcrumbs(int $id, bool $lastIsALink=false):string
	{
//		$id = $category->id;
		$parents = IlluminateCategory::with('category_recursive.properties.vals')
			->find($id)->toArray();

		$arr = [];
		$finalCategory = self::getLast($lastIsALink,$parents);
		while (self::hasCat($parents)) {
			$id = $parents['category_recursive']['id'];
			$name = $parents['category_recursive']['name'];
			array_push($arr,
				"<a href=/adminsc/category/edit/{$id}>{$name}</a>");
			$parents = $parents['category_recursive'];
		}
		$arr = array_reverse($arr);
		array_push($arr,$finalCategory);
		$breadcrumbs = implode('&nbsp;>&nbsp;',$arr);
		return "<div class='breadcrumbs'>{$breadcrumbs}</div>";
	}

	public static function edit($id): string
	{
		$view = new self();

		$illumCategory = IlluminateCategory::with('products', 'category_recursive', 'properties','children')
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
//						MyList::build(IlluminateCategory::class)
						MyList::build(IlluminateCategory::class)
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