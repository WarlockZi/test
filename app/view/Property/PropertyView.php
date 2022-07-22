<?php


namespace app\view\Property;


use app\model\Property;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomList\CustomList;
use app\view\MyView;
use app\view\Val\ValView;


class PropertyView extends MyView
{

	public $model = Property::class;
	public $html;

	public function __construct()
	{
		parent::__construct();
		$this->model = new $this->model;
	}

	public static function edit($id)
	{
		$view = new self();

		$item = $view->model::where('id', '=', $id)->get()[0];
		$view->getItem($item);
		$item = $view->html;

		return [$item];
	}

	public static function index($model): string
	{
		$view = new self($model);
		return $view->html;
	}


	public static function selector(int $selected, int $exclude = -1): string
	{

	}


	private function getItem($item): void
	{
		$options = $this->getOptions($item);

		$t = new CustomCatalogItem($options);
		$this->html = $t->html;
	}

	protected function getList()
	{
		return new CustomList(
			[
				'models' => $this->items,
				'modelName' => $this->model->model,
				'tableClassName' => $this->model->table,
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
					'html' => ValView::listBelongsTo($this->model,$item['id']),
				],
			],
			'fields' => [
				'ID' => [
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