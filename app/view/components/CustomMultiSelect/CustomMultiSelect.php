<?php


namespace app\view\components\CustomMultiSelect;


class CustomMultiSelect
{
	private $field = '';
	private $className = '';
	private $tab = '.';
	private $tree = [];
	private $title = '';
	private $optionLabel= 'name';
	private $selected = [];
	public $html = '';
	private $tpl = ROOT.'/app/view/components/CustomMultiSelect/tpl.php';

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
		require $this->tpl;
		return ob_get_clean();
	}


	public function run()
	{
//		$model = new self($options);
		ob_start();
		include ROOT . '/app/view/components/CustomMultiSelect/CustomMultiSelectTemplate.php';
		$html = ob_get_clean();
		$this->html = $html;
//		return ;
	}


}