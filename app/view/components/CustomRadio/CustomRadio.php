<?php


namespace app\view\components\CustomRadio;


use app\core\FS;

class CustomRadio
{
	private $field = 'field';
	private $className = '';
	private $tree = [];
	private $title = '';

	private $fieldName = '';
	private $selected = '';

	public $html;

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

	public function getChilds($tree,$level)
	{
		$str = '';
		foreach ($tree as $id => $item) {
			$str .= $this->getOption($item,$level+1);
		}
		return $str;
	}

	public function getOption($item,$level)
	{
		ob_start();
		require $this->finalTpl;
		return ob_get_clean();
	}


	public function run()
	{
		$this->html = FS::getFileContent(ROOT . '/app/view/components/CustomRadio/CustomRadioTemplate.php');
		return $this->html;
	}


}