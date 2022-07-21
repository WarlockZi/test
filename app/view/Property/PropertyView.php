<?php


namespace app\view\Property;


use app\model\Category;
use app\model\Property;
use app\model\Val;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomList\CustomList;
use app\view\Product\ProductView;
use app\view\Val\ValView;


class PropertyView
{

	private $items;
	private $modelName = 'property';
	private $tableName = 'properties';
	public $html;

	public function __construct(string $class)
	{
		$this->model = new $class;
	}

	public static function edit(string $model, $id)
	{
		$view = new self($model);

		$item = $model::where('id','=',$id)->get()[0];
		$view->getItem($item);
		$item = $view->html;

		$vals = ValView::list(Val::class,$id);

		return [$item,$vals];
	}

	public static function index($model): string
	{
		$view = new self($model);
		return $view->html;
	}

	public static function list(string $class): string
	{
		$view = new self($class);
		$list = $view->getList($view->items)->html;

		return $list;
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



	private function getItem($item): void
	{
		$options = $this->getOptions($item);
		$t = new CustomCatalogItem($options);
		$this->html = $t->html;
	}

	private function getList(array $items)
	{
		return new CustomList(
			[
				'models' => $items,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type' => 'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => true,
				'delCol' => true,
				'addButton' => 'ajax'
			]
		);
	}

	private function getOptions($item)
	{

		return [
			'item' => $item,
			'modelName' => $this->model->model,
			'tableClassName' => $this->model->table,
			'pageTitle' => '',
			'tabs' => [
				['title' => 'Значения',
					'html' => ValView::list(Val::class,$item['id']),
					'field' => 'products'
				],
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

	private static function noElement()
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