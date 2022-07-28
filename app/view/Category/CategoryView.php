<?php

namespace app\view\Category;

use app\model\Category;
use app\model\Illuminate\Category as IlluminateCategory;
use app\model\Product;
use app\model\Property;
use app\view\components\Builders\Item\ItemFieldBuilder;
use app\view\components\Builders\Item\ItemTabBuilder;
use app\view\components\Builders\ListColumnBuilder;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\MyItem\MyItem;
use app\view\components\MyList\MyList;
use app\view\Product\ProductView;

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

		$category = IlluminateCategory::with('products', 'parent_rec', 'properties')
			->where('id', '=', $id)
			->get()[0];
		$category = $category->toArray();
		$products = $category['products'] ?? [];

		$properties = Property::where('category_id', '=', $id)
				->get() ?? [];

		return MyItem::build($view->model, $id)
			->pageTitle('Редактировать категорию :  '.$category['name'])
			->field(
				ItemFieldBuilder::build('id')
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name')
					->contenteditable()
					->required()
					->get()
			)
			->tab(
				ItemTabBuilder::build()
					->tabTitle('Товары')
					->html(
						MyList::build(Product::class)
							->column(
								ListColumnBuilder::build('id')
									->get()
							)
							->column(
								ListColumnBuilder::build('name')
									->get()
							)
							->items($products)
							->edit()
							->get()
					)
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
							->items($properties)
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

	public static function show(Model $model)
	{
		$view = new self($model);
		$view->getHtml($model->fillable, $model);
		return $view->html;
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

	private function getHtml(): void
	{
		$options = $this->getOptions();
		$t = new CustomCatalogItem($options);
		$this->html = $t->html;
	}


	private function getOptions()
	{
		$cat = new $this->model;
		$cat = $cat->all()->toArray();
		return [
			'item' => $cat,
			'modelName' => $this->model->model,
			'tableClassName' => $this->model->table,
			'pageTitle' => '',
			'tabs' => [
				['title' => 'Товары',
					'html' => ProductView::belongToCategory($this->model),
					'field' => 'products'
				],
				['title' => 'Родительские категории',
					'html' => self::getParents($cat),
					'field' => 'ParentProps'
				],
				['title' => 'Родительские свойства',
					'html' => self::getParents($cat),
					'field' => 'ParentProps'
				]
			],
			'fields' => [
				'ID' => [
					'field' => 'id',
					'contenteditable' => false,
				],
				'Папка' => [
					'field' => 'id',
					'contenteditable' => false,
				],
				'Имя' => [
					'field' => 'name',
					'contenteditable' => true,
					'required' => true,
				],


			],
			'delBttn' => true,
			'saveBttn' => true,

		];
	}

	private function noElement()
	{
		ob_start();
		?>
	  <div class="no-element">
		  <div class="error">Категория не найдена</div>
	  </div>
		<?
		return ob_get_clean();
	}

	public static function getParents(array $cat, &$str = '')
	{
		if ($cat['parent_rec'] !== null) {
			$str .= '<div>' . $cat['parent_rec']['name'] . '</div>';
			self::getParents($cat['parent_rec'], $str);
		}
		return $str;
	}


}