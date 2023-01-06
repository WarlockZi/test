<?php


namespace app\view\components\Builders\ListBuilder;


use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Collection;

class MyList
{
	private $grid = "style='display: grid; grid-template-columns:";

	private $model = '';
	private $pageTitle = '';
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
	private $morphDetach;
	private $morphOneOrMany;

	public static function build(string $modelName)
	{
		$view = new static();
		$view->model = new $modelName;
		$model = strtolower(class_basename($view->model));
		$view->dataModel = "data-model='{$model}'";
		return $view;
	}

	public function parent(string $model, $id)
	{
		$this->parent = "data-parent=" . $model;
		$this->parentId = "data-parentId=" . $id;
		return $this;
	}

	public function pageTitle(string $pageTitle)
	{
		$this->pageTitle = $pageTitle;
		return $this;
	}

	public function morph(string $model, int $id, string $oneOrMany = 'one', bool $detach = false)
	{
		$this->morph = "data-morph={$model}";
		$this->morphId = "data-morphId={$id}";
		$this->morphOneOrMany = "data-morphOneOrMany={$oneOrMany}";
		$detach = $detach?'true':'false';
		$this->morphDetach = "data-morphDetach={$detach}";
		return $this;
	}

	public function all()
	{
		$this->items = $this->model::all();
		return $this;
	}

	public function tableClass(string $class)
	{
		$this->tableClassName = $class;
		return $this;
	}

	public function column(ListColumnBuilder $a)
	{
		$this->columns[$a->field] = $a;
		return $this;
	}

	public function items(Collection $items)
	{
		$this->items = $items;
		return $this;
	}

	public function addButton(string $ajaxOrRedirect)
	{
		$this->addButton = $ajaxOrRedirect;
		return $this;
	}

	public function del()
	{

		$this->headDelCol = "<div class='head del'></div>";
		return $this;
	}

	public function edit()
	{
		$this->headEditCol = "<div class='head edit'></div>";
		return $this;
	}

	protected function getEditButton(int $itemId)
	{
		if ($this->headEditCol) {
			$hidden = $itemId ? '' : 'hidden';
			$str = "<div {$hidden} class='edit'  $this->dataModel " .
				"data-id='{$itemId}'></div>";
			return $str;
		}
	}

	protected function getDelButton(int $itemId)
	{
		if ($this->headDelCol) {
			$hidden = $itemId ? '' : 'hidden';
			$str = "<div {$hidden} class='del' $this->dataModel " .
				"data-id='{$itemId}'></div>";
			return $str;
		}
	}

	protected function emptyRow()
	{
		$str = '';
		foreach ($this->columns as $field => $column) {

			$str .= "<div hidden {$column->class} " .
				$column->dataField .
				"data-id='0' " .
				"{$column->contenteditable}" .
				">{$this->getEmpty($column)}</div>";
		}
		$str .= $this->getEditButton(0);
		$str .= $this->getDelButton(0);

		return $str;
	}

	protected function prepareGridHeader(): void
	{
		foreach ($this->columns as $colName => $column) {
			$this->grid .= ' ' . $column->width;
		}
		if ($this->headEditCol) {
			$this->grid .= ' 50px';
		}
		if ($this->headDelCol) {
			$this->grid .= ' 50px';
		}
		$this->grid .= "'";
	}

	protected function getEmpty($column)
	{
		if ($column->select) {
			return $column->select->getEmpty();
		} else {
			return '';
		}
	}

	protected function getData($column, $item, $field)
	{
		if ($column->function) {
			$func = $column->function;
			return $column->functionClass::$func($item);
		} else if ($column->select) {
			return $column->select->get($item->$field ?? 0);
		} else {
			return $item[$field];
		}
	}

	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/ListBuilder/MyListTemplate.php';
		$this->html = ob_get_clean();
	}

	public function get()
	{
		$this->prepareGridHeader();
		$this->template();

		return $this->html;
	}
}