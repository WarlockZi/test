<?php


namespace app\view\components\CustomList;


class CustomList
{
	private $columns = [];
	private $editCol = false;
	private $delCol = false;
	private $grid = 'grid-template-columns:';
	private $models = [];
	private $modelName = '';
	private $tableClassName = '';
	private $searchStr = ' <input type="text">';
	private $template = '';
	private $header = '';
	public $html = '';


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
		$this->gridTemplate();

		return $this->template();
	}

	protected function gridTemplate(): void
	{
		foreach ($this->columns as $colName => $data) {
			$this->grid .= ' ' . $data['width'] ?? ' 1fr';

		}
		$this->grid .= $this->editCol ? ' 50px' : '';
		$this->grid .= $this->delCol ? ' 50px' : '';
	}

	protected function prepareData(array $column, array $model): string
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