<?php


namespace app\view\components\Builders\ListBuilder;


use app\core\Icon;
use Illuminate\Database\Eloquent\Collection;

class MyList
{
	private $grid;

	private $model;
	private $dataModel;
	private $tableClassName;

	private $pageTitle;

	private $addButton = false;
	private $columns = [];
	private $items = [];

	private $headEditCol;
	private $headDelCol;

//	private $belongsTo;
//	private $belongsToId;

	private $relation;

//	private $morph;
//	private $morphId = null;
//	private $morphDetach;
//	private $morphOneOrMany;

	public static function build(string $modelName, int $count = 0)
	{
		$view = new static();
		$view->model = new $modelName;
		$view->setImtems($count);
		$model = strtolower(class_basename($view->model));
		$view->dataModel = "data-model='{$model}'";
		return $view;
	}

	protected function setImtems(int $count)
	{
		if ($count) {
			$this->items = $this->model::all()->take($count);
		} else {
			$this->items = $this->model::all();
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

//	public function belongsTo(string $model, $id)
//	{
//		$this->realtion();
//		$this->belongsTo = "data-belongs-to=" . $model;
//		$this->belongsToId = "data-belongs-to-id=" . $id;
//		return $this;
//	}

	public function realtion(string $relation)
	{
		$this->relation = "data-relation = '{$relation}'";
		return $this;
	}

	public function pageTitle(string $pageTitle)
	{
		$this->pageTitle = "<div class='list-title'>{$pageTitle}</div>";
		return $this;
	}

//	public function morph(string $model, int $id, string $oneOrMany = 'one', bool $detach = false)
//	{
//		$this->morph = "data-morph={$model}";
//		$this->morphId = "data-morphId={$id}";
//		$this->morphOneOrMany = "data-morphOneOrMany={$oneOrMany}";
//		$detach = $detach ? 'true' : 'false';
//		$this->morphDetach = "data-morphDetach={$detach}";
//		return $this;
//	}

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

	public function addButton(string $ajaxOrRedirect)
	{
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
		$this->prepareGridHeader();
		$this->template();

		return $this->html;
	}


	// пример функции получения ссылки. Должна располагаться не здесь,
	// а в любом другом классе, указанном в функции funcion ListColumnBuilder
//	public function getLink($column, $item, $field){
//		$href = '/adminsc/category/edit/'.$item->id;
//		return "<a href = {$href}>Редакт категорию {$item->id}</a>";
//	}

}