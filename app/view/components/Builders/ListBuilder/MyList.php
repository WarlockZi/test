<?php


namespace app\view\components\Builders\ListBuilder;


use app\core\Icon;
use Illuminate\Database\Eloquent\Collection;

class MyList
{
	private $pageTitle;

	private $grid;
	private $class;

	private $addButton = false;
	private $columns = [];
	private Collection $items;

	private $headEditCol;
	private $headDelCol;
	private $model;
	private $modelName;
	private $dataModel;

	private $relation;

	public static function build(string $modelName, int $count = 0)
	{
		$list = new static();

		$list->modelName = $modelName;
		$model = new $modelName;
		$list->model = $model;
		$model = strtolower(class_basename($modelName));
		$list->dataModel = "data-model='{$model}'";
		return $list;
	}

	protected function setItems()
	{
		if (!$this->items) {
			$this->items =  $this->modelName::all();
		}
	}

	public function link(string $field,
											 string $classHeader,
											 string $class,
											 string $name,
											 string $width,
											 string $className,
											 string $funcName)
	{
		$this->columns[$field] = ListColumnBuilder::build($field)
			->classHeader($classHeader)
			->class($class)
			->name($name)
			->width($width)
			->function($className, $funcName)
			->get();
	}


	public function relation(string $relation)
	{
		$this->relation = "data-relation = '{$relation}'";
		return $this;
	}
	public function class(string $class)
	{
		$this->class = "class = '{$class}'";
		return $this;
	}

	public function pageTitle(string $pageTitle)
	{
		$this->pageTitle = "<div class='list-title'>{$pageTitle}</div>";
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

	public function column(ListColumnBuilder $column)
	{
		$this->columns[$column->field] = $column;
		return $this;
	}

	public function items(Collection $items)
	{
		$this->items = $items;
		return $this;
	}

//	public function addButton()
	public function addButton(string $ajaxOrRedirect)
	{
//		$this->addButton = true;
		$this->addButton = $ajaxOrRedirect;
		return $this;
	}

	protected function getId(int $itemId): string
	{
		return "data-id={$itemId}";
	}

	protected function getEditButton(int $itemId): string
	{
		if ($this->headEditCol) {
			$hidden = $itemId ? '' : 'hidden';
			return "<div {$hidden} class='edit'  $this->dataModel " .
				"data-id='{$itemId}'></div>";
		}
		return '';
	}

	protected function getDelButton(int $itemId): string
	{
		if ($this->headDelCol) {
			$hidden = $itemId ? '' : 'hidden';
			$str = "<div {$hidden} class='del' $this->dataModel " .
				"data-id='{$itemId}'></div>";
			return $str;
		}
		return '';
	}

	protected function emptyRow(): string
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

	public function del()
	{
		$this->columns['del'] = ListColumnBuilder::build('del')
			->classHeader('head del')
			->class('del')
			->name(Icon::trashIcon())
			->width('50px')
			->get();
		return $this;
	}

	public function edit()
	{
		$this->columns['edit'] = ListColumnBuilder::build('edit')
			->classHeader('head edit')
			->class('edit')
			->name(Icon::editWhite())
			->width('50px')
			->get();

		return $this;
	}

	protected function prepareGridHeader(): void
	{
		$columns = '';
		foreach ($this->columns as $colName => $column) {
			$columns .= ' ' . $column->width;
		}

		$this->grid .= "style='display: grid; grid-template-columns:{$columns}'";
	}

	protected function getData($column, $item, $field)
	{
		if ($column->function) {
			$func = $column->function;
			return $column->functionClass::$func($column, $item, $field);
		} else if ($column->select) {
			return $column->select->get($item->$field ?? 0);
		} else {
			return $item[$field];
		}
	}

	protected function getEmpty($column)
	{
		if ($column->select) {
			return $column->select->getEmpty();
		}
		return '';
	}


	protected function template()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/ListBuilder/MyListTemplate.php';
		$this->html = ob_get_clean();
	}

	public function get()
	{
		$this->setItems();
		$this->prepareGridHeader();
		$this->template();

		return $this->html;
	}

}