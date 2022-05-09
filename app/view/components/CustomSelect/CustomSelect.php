<?php


namespace app\view\components\CustomSelect;


class CustomSelect
{
	private $field = '';
	private $className = '';
	private $tab = '.';
	private $tree = [];
	private $title = '';

	private $initialOption = false;
	private $initialOptionValue = '--';
	private $optionName = '';
	private $selected = [];
	private $type = 'string';
	private $pathToTpl = ROOT.'/app/view/components/CustomSelect/';
	private $tpl = 'tpl.php';
	private $finalTpl;
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
		$this->finalTpl=$this->pathToTpl.$this->tpl;
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
//		$model = new self();
		ob_start();
		include ROOT . '/app/view/components/CustomSelect/CustomSelectTemplate.php';
		$t = ob_get_clean();
		$this->html = $t;
		return $t;
	}


}