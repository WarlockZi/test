<?php


namespace app\view\components\MyList;


class MyList
{
	private $grid = 'grid-template-columns:';

	private $model = '';
	public $addButton = false;
	private $tableClassName = '';
	private $columns = [];
	private $items = [];
	private $delCol = false;
	private $editCol = false;
	private $parent = '';
	private $parentId = null;

	public $html = '';

	public function __construct()
	{

	}

	public function parent($model, $id)
	{
		$this->parent = $model;
		$this->parentId = $id;
		return $this;
	}

	public static function create(string $modelName)
	{
		$view = new static();
		$view->model = new $modelName;
		return $view;
	}

	public function tableClass(string $class)
	{
		$this->tableClassName = $class;
		return $this;
	}
	public function get()
	{
		$this->run();
		return $this->html;
	}

	protected function getColumn(){
		return
		[
			'name' => 'Поле',
			'type' => 'string',
			'class' => '',
			'sort' => false,
			'search' => false,
			'width' => '50px',
			'hidden' => false,
			'contenteditable' => true
		];
	}

	public function column(array $a)
		{
			$col[$a['field']]= $this->getColumn();
			foreach ($col[$a['field']] as $k=>$v) {
				if (array_key_exists($k,$a)){
					$col[$a['field']][$k]=$a[$k];
				}
			}
			$this->columns[$a['field']]=$col[$a['field']];

		return $this;
	}

	public function del()
	{
		$this->delCol = true;
		return $this;
	}

	public function addButton(string $ajaxOrRedirect)
	{
		$this->addButton = $ajaxOrRedirect;
		return $this;
	}

	public function edit()
	{
		$this->editCol = true;
		return $this;
	}

	public function items(array $items)
	{
		$this->items = $items;
		return $this;
	}

	protected function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	protected function run()
	{
		$this->prepareGgridHeader();

		return $this->template();
	}

	protected function prepareGgridHeader(): void
	{
		foreach ($this->columns as $colName => $data) {
			$this->grid .= ' ' . $data['width'] ?? ' 1fr';

		}
		if ($this->editCol) {
			$this->grid .= $this->editCol ? ' 50px' : '';
		}

		if ($this->delCol) {
			$this->grid .= $this->delCol ? ' 50px' : '';
		}
	}

	protected function getSearchString()
	{
		return '<input type="text">';
	}

	protected function getEditButton($model, $field, $column)
	{
		include ROOT . '/app/view/components/MyList/edit.php';
		return $edit;
	}

	protected function getDelButton($model, $field, $column)
	{
		include ROOT . '/app/view/components/MyList/del.php';
		return $del;

	}

	protected function emptyRow(array $columns)
	{
		$str = '';
		$model['id'] = 0;

		foreach ($columns as $field => $column) {
			$contenteditable = $column['contenteditable'] ?'contenteditable': '';
			$hidden = 'hidden';
			$class = $column['class']?$column['class']:$field;

			$str .= "<div {$hidden} class='{$class}' " .
				"data-field='{$field}' " .
				"data-id='0' " .
				"{$contenteditable}" .
				"></div>";
		}
		include ROOT . '/app/view/components/MyList/edit.php';
		$str .= $edit;

		include ROOT . '/app/view/components/MyList/del.php';
		$str .= $del;

		return $str;
	}


	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/MyList/MyListTemplate.php';
		$this->html = ob_get_clean();
		return $this->html;
	}

}