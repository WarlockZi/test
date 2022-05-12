<?php


namespace app\view\components\CustomCatalogItem;


class CustomCatalogItem
{
	public $item = [];
	public $fields = [];
	public $pageTitle = '';

	public $html = '';

	public $models = [];
	public $modelName = '';
	public $tableClassName = '';
	private $tabs = '';

	private $saveBttn = false;
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
		ob_start();
		include ROOT . '/app/view/components/CustomCatalogItem/CustomCatalogItemTemplate.php';
		$this->html = ob_get_clean();
	}

}