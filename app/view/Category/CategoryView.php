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

class CategoryView
{
	private $model = IlluminateCategory::class;
	private $modelName = 'category';
	public $html;

	public function __construct()
	{
	}

	public static function edit($id): string
	{
		$view = new self();

		$illumCategory = IlluminateCategory::with('products', 'parent_rec', 'properties')
			->find($id);
		$category = $illumCategory->toArray();

		return ItemBuilder::build($illumCategory, 'category')
			->pageTitle('Редактировать категорию :  ' . $category['name'])
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
				ItemTabBuilder::build('Товары')
					->html(
						MyList::build(Product::class)
							->parent('category',$id)
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
				ItemTabBuilder::build('Свойства')
					->html(
						MyList::build(Property::class)
							->column(
								ListColumnBuilder::build('id')
									->width('40px')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->name("Назввание")
									->get()
							)
							->items($illumCategory->properties ?? [])
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

//	public static function selectWithSelectedExcluded(int $selected, int $exclude = -1): string
//	{
//		$tests = Opentest::where('isTest', '=', '1')->get();
//		$parent_select = '<select>';
//		$parent_select .= "<option value=0>---</option>";
//		foreach ($tests as $t) {
//			if ((int)$t['id'] !== $exclude) {
//				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
//				$parent_select .= "<option value={$t['id']} {$selectedStr}>{$t['name']}</option>";
//			}
//		}
//		$parent_select .= "</select>";
//
//		return $parent_select;
//	}

//	private function getHtml(): void
//	{
//		$options = $this->getOptions();
//		$t = new CustomCatalogItem($options);
//		$this->html = $t->html;
//	}

//
//	private function getOptions()
//	{
//		$cat = new $this->model;
//		$cat = $cat->all()->toArray();
//		return [
//			'item' => $cat,
//			'modelName' => $this->model->model,
//			'tableClassName' => $this->model->table,
//			'pageTitle' => '',
//			'tabs' => [
//				['title' => 'Товары',
//					'html' => ProductView::belongToCategory($this->model),
//					'field' => 'products'
//				],
//				['title' => 'Родительские категории',
//					'html' => self::getParents($cat),
//					'field' => 'ParentProps'
//				],
//				['title' => 'Родительские свойства',
//					'html' => self::getParents($cat),
//					'field' => 'ParentProps'
//				]
//			],
//			'fields' => [
//				'ID' => [
//					'field' => 'id',
//					'contenteditable' => false,
//				],
//				'Папка' => [
//					'field' => 'id',
//					'contenteditable' => false,
//				],
//				'Имя' => [
//					'field' => 'name',
//					'contenteditable' => true,
//					'required' => true,
//				],
//
//
//			],
//			'delBttn' => true,
//			'saveBttn' => true,
//
//		];
//	}


//	public static function getParents(array $cat, &$str = '')
//	{
//		if ($cat['parent_rec'] !== null) {
//			$str .= '<div>' . $cat['parent_rec']['name'] . '</div>';
//			self::getParents($cat['parent_rec'], $str);
//		}
//		return $str;
//	}


}