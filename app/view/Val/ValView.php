<?php


namespace app\view\Val;


use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomList\CustomList;


class ValView
{

	private $items;
	private $model = '\app\model\Val';
	private $modelName = 'val';
	private $parent = 'property_id';
	private $tableName = 'vals';
	public $html;

	public function __construct()
	{
		$this->model = new $this->model;
	}

	public static function edit(string $model, $id)
	{
		$view = new self($model);
		$vals = ValView::list;

		return $view->html;
	}


	public static function index($model): string
	{
		$view = new self($model);
		return $view->html;
	}


	public static function belongToProperty($model, $id): string
	{
		$view = new self($model);
		$items = $view->model::where('property_id', '=', $id)->get();
		$view->getHtml($items);
		return $view->html;
	}

	public static function list(string $class, $id): string
	{
		$view = new self($class);
		$items = $view->model::where('property_id', '=', $id)->get();
		$list = $view->getList($items)->html;

		return $list;
	}


	private function getHtml($item): void
	{
		$options = $this->getOptions($item);
//		$t = new CustomCatalogItem($options);
		$t = new CustomList($options);
		$this->html = $t->html;
	}

	private function getList(array $items)
	{
		return new CustomList(
			[
				'models' => $items,
				'parent' => $this->parent,
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
					'property_id' => [
						'className' => 'description',
						'field' => 'property_id',
						'name' => 'родитель',
						'width' => '50px',
						'contenteditable' => '',
						'data-type' => 'string',
						'sort' => false,
						'search' => false,
					],
				],
				'editCol' => false,
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

			'fields' => [
				'ID' => [
					'field' => 'id',
					'contenteditable' => false,
				],
				'Наименование' => [
					'field' => 'name',
					'contenteditable' => true,
				],
				'Тип' => [
					'field' => 'ензу',
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