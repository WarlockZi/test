<?php


namespace app\view\components\CustomCatalogItem;


class CustomCatalogItem
{
	private $item = [];
	private $fields = [];
//	private $filter = '';

	public $html = '';

	private $models = [];
	private $modelName = '';
	private $tableClassName = '';

	private $saveBttn = 'ajax';
	private $toListBttn = false;
	private $delBttn = true;

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
		return $this->template();
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
		include ROOT . '/app/view/components/CustomCatalogItem/CustomCatalogItemTemplate.php';
		$t = ob_get_clean();
		$this->html = $t;
		return $t;
	}

}