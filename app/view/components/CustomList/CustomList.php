<?php


namespace app\view\components\CustomList;


use app\core\FS;

class CustomList
{
	public $html = '';
	public $addButton = false;
	private $columns = [];
	private $grid = 'grid-template-columns:';
	private $delCol = false;
	private $editCol = false;
	private $searchStr = '<input type="text">';
//	private $tableClassName = '';
	private $model = '';
	private $field = '';
//	private $filter = '';
	private $models = [];
//	private $parent = '';
//	private $parentId = null;


	public function __construct($options)
	{
		$this->getOptions($options);
		$this->searchStr = $this->getSearchString();
		$this->run();
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
		include ROOT . '/app/view/components/CustomList/edit.php';
		return $edit;
	}

	protected function getDelButton($model, $field, $column)
	{
		include ROOT . '/app/view/components/CustomList/del.php';
		return $del;

	}

	protected function emptyRow(array $columns)
	{
		$str = '';
		$model['id'] = 0;
		$hidden = 'hidden';
		foreach ($columns as $field => $column) {
			$contenteditable = $column['contenteditable'] ?? '';

			$str .= "<div {$hidden} class='{$column['className']}' " .
				"data-field='{$field}' " .
				"data-id='0' " .
				"{$contenteditable}" .
				"></div>";
		}
		include ROOT . '/app/view/components/CustomList/edit.php';
		$str .= $edit;

		include ROOT . '/app/view/components/CustomList/del.php';
		$str .= $del;

		return $str;
	}

	protected function prepareData(array $column, array $model)
	{

		if (isset($column['concat'])) {
			$initValue = '';
			foreach ($column['concat'] as $v) {
				$initValue .= trim($model[$v]) . ' ';
			}
			return trim($initValue);
		}

		return $model[$column['field']];
	}


	protected function template()
	{
		$this->html = FS::getFileContent(ROOT . '/app/view/components/CustomList/CustomListTemplate.php');
		return $this->html ;
	}

}