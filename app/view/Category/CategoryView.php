<?php


namespace app\view\Category;


use app\model\Category;
use app\model\MyCategory;
use app\model\Product;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\Product\ProductView;

class CategoryView
{

	private $model;
	public $html;

	public function __construct(Category $category)
	{
		$this->model = $category;
	}

	public static function edit(Category $model): string
	{
		$view = new self($model);
		if ($model) {
			$view->getHtml();
		} else {
			$view->noElement();
		}
		return $view->html;
	}


	public static function show(Model $model)
	{
		$view = new self($model);
		$view->getHtml($model->fillable, $model);
		return $view->html;
	}

	public static function parentSelector(int $selected, int $exclude = -1): string
	{
		$tests = Opentest::where('isTest', '=', '1')->get();
		$parent_select = '<select>';
		$parent_select .= "<option value=0>---</option>";
		foreach ($tests as $t) {
			if ((int)$t['id'] !== $exclude) {
				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
				$parent_select .= "<option value={$t['id']} {$selectedStr}>{$t['name']}</option>";
			}
		}
		$parent_select .= "</select>";

		return $parent_select;
	}

	public static function selectWithSelectedExcluded(int $selected, int $exclude = -1): string
	{
		$tests = Opentest::where('isTest', '=', '1')->get();
		$parent_select = '<select>';
		$parent_select .= "<option value=0>---</option>";
		foreach ($tests as $t) {
			if ((int)$t['id'] !== $exclude) {
				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
				$parent_select .= "<option value={$t['id']} {$selectedStr}>{$t['name']}</option>";
			}
		}
		$parent_select .= "</select>";

		return $parent_select;
	}

	private function getHtml(): void
	{
		$options = $this->getOptions();
		$t = new CustomCatalogItem($options);
		$this->html = $t->html;
	}


	private function getOptions()
	{
		return [
			'item' => $this->model,
			'modelName' => $this->model->model,
			'tableClassName' => $this->model->table,
			'pageTitle' => '',
			'tabs' => [
				['title' => 'Товары',
					'html' => ProductView::belongToCategory($this->model),
					'field' => 'products'
				],
				['title' => 'Родительские свойства',
					'html' => '<div>Металлоподносок</div>',
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


}