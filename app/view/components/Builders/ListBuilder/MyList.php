<?php


namespace app\view\components\Builders\ListBuilder;


class MyList
{
	private $grid = "style='display: grid; grid-template-columns:";

	private $model = '';
	private $dataModel = '';
	private $addButton = false;
	private $tableClassName = '';
	private $columns = [];
	private $items = [];
	private $headEditCol = '';
	private $headDelCol = '';
	private $parent = '';
	private $parentId = null;
	private $morph = '';
	private $morphId = null;

//	public $html = '';

	public static function build(string $modelName)
	{
		$view = new static();
		$view->model = new $modelName;
		$view->dataModel = "data-model='{$view->model->model}'";
		return $view;
	}

	public function parent(string $model, $id)
	{
		$this->parent = "data-parent=" . $model;
		$this->parentId = "data-parentId=" . $id;
		return $this;
	}

	public function morph(string $model, $id)
	{
		$this->morph = "data-morph=" . $model;
		$this->morphId = "data-morphId=" . $id;
		return $this;
	}

	public function all()
	{
		$this->items = $this->model::findAll();
		return $this;
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

	public function column(array $a)
	{
		$this->columns[$a['field']] = $a;
		return $this;
	}


	public function del()
	{
		$TRASH = file_get_contents(TRASH);
		$this->headDelCol = "<div class='head del'>{$TRASH}</div>";
		return $this;
	}

	public function edit()
	{
		$EDIT = file_get_contents(EDIT);
		$this->headEditCol = "<div class='head edit'>{$EDIT}</div>";
		return $this;
	}

	public function addButton(string $ajaxOrRedirect)
	{
		$this->addButton = $ajaxOrRedirect;
		return $this;
	}


	public function items(array $items)
	{
		$this->items = $items;
		return $this;
	}

	protected function getEditButton(int $itemId)
	{
		if ($this->headEditCol) {
			$hidden = $itemId?'':'hidden';
			$str = "<div {$hidden} class='edit'  $this->dataModel " .
				"data-id='{$itemId}'></div>";
			return $str;
		}
	}

	protected function getDelButton(int $itemId)
	{
		if ($this->headDelCol) {
			$hidden = $itemId?'':'hidden';
			$str =  "<div {$hidden} class='del' $this->dataModel " .
				"data-id='{$itemId}'></div>";
			return $str;
		}
	}

	protected function emptyRow()
	{
		$str = '';

		foreach ($this->columns as $field => $column) {

			$str .= "<div hidden {$column['class']} " .
				$column['dataField'] .
				"data-id='0' " .
				"{$column['contenteditable']}" .
				"></div>";
		}
		$str .= $this->getEditButton(0);
		$str .= $this->getDelButton(0);

		return $str;
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
		if ($this->headEditCol) {
			$this->grid .= ' 50px';
		}

		if ($this->headDelCol) {
			$this->grid .= ' 50px';
		}
		$this->grid .= "'";
	}


	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/ListBuilder/MyListTemplate.php';
		$this->html = ob_get_clean();
		return $this->html;
	}

}