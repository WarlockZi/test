<?php


namespace app\view\components\CustomSelect;


class CustomSelect
{
	private $title = '';
	private $selectClassName = '';
	private $field = 'field';
	private $tab = '.';
	private $initialOption = false;
	private $initialOptionValue = '--';
	private $nameFieldName = 'name';
	private $type = 'string';
	private $tree = [];
	private $pathToTpl = ROOT.'/app/view/components/CustomSelect/';
	private $tpl = 'tpl.php';
	private $finalTpl;

	public function __construct($options)
	{
		$this->getOptions($options);
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


	public static function run($options)
	{
		$model = new self($options);
		ob_start();
		include ROOT . '/app/view/components/CustomSelect/CustomSelectTemplate.php';
		$t = ob_get_clean();
//		$model->html = $t;
		return $t;
	}


}