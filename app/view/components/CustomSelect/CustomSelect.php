<?php


namespace app\view\components\CustomSelect;


class CustomSelect
{
	private $field = '';
	private $class = '';
	private $tab = '.';
	private $title = '';
	private $tree = [];
	private $selected = [];
	private $exclude = [];

	private $initialOptionValue = 0;
	private $initialOptionLabel = null;
	private $optionName = '';
	private $type = 'string';

	private $finalTpl = ROOT.'/app/view/components/CustomSelect/tpl.php';
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
		ob_start();
		include ROOT . '/app/view/components/CustomSelect/CustomSelectTemplate.php';
		$t = ob_get_clean();
		$this->html = $t;
		return $t;
	}

}