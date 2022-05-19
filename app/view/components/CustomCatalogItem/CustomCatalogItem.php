<?php


namespace app\view\components\CustomCatalogItem;


use app\model\Model;

class CustomCatalogItem
{
	public $pageTitle = '';
	public $item = null;
	public $fields = [];

//	public $models = [];
	public $modelName = '';
	public $tableClassName = '';
	private $tabs = '';

	private $saveBttn = false;
	private $toListBttn = false;
	private $delBttn = true;

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
		ob_start();
		include ROOT . '/app/view/components/CustomCatalogItem/CustomCatalogItemTemplate.php';
		$this->html = ob_get_clean();
	}

}