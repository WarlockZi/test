<?php


namespace app\view\components\CustomList;


class CustomList
{
	public $html = '';
	public $addButton = false;
	private $columns = [];
	private $grid = 'grid-template-columns:';
	private $delCol = false;
	private $editCol = false;
	private $searchStr = ' <input type="text">';
	private $tableClassName = '';
	private $modelName = '';
	private $field = '';
	private $filter = '';
	private $models = [];


	public function __construct($options)
	{
		$this->getOptions($options);
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
		ob_start();
		include ROOT . '/app/view/components/CustomList/CustomListTemplate.php';
		$t = ob_get_clean();
		$this->html = $t;
		return $t;
	}

}