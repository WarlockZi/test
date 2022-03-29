<?php


namespace app\view\components\CustomListTree;


class CustomListTree
{
	private $separator = '';
	private $initialOption = false;
	private $tree = [];

	public function __construct($options)
	{
		$this->getOptions($options);
//		$this->run();
	}

	protected function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	public static function run($options)
	{
		$model = new self($options);
		$select = '';
		foreach ($model->tree as $id => $item) {
			$select.= $model->template($item);
		}
		return $select;
	}


	protected function template($item)
	{
		ob_start();
		include ROOT . '/app/view/components/CustomListTree/CustomListTreeTemplate.php';
		$t = ob_get_clean();
		$this->html = $t;
		return $t;
	}

}