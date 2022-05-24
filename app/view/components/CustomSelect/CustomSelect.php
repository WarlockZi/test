<?php


namespace app\view\components\CustomSelect;


class CustomSelect
{
	private $field = '';
	private $class = '';
	private $tab = '- ';
	private $title = '';
	private $tree = [];
	private $selected = [];
	private $exclude = [];

	private $initialOptionValue = 0;
	private $initialOptionLabel = null;
	private $optionName = 'name';
	private $type = 'string';

	private $finalTpl = ROOT . '/app/view/components/CustomSelect/tpl.php';
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

	public function getChilds($tree, $level)
	{
		$str = '';
		foreach ($tree as $id => $item) {
			$str .= $this->getOption($item, $level + 1);
		}
		return $str;
	}

	public function getOption($item, $level)
	{
		ob_start();
		require $this->finalTpl;
		return ob_get_clean();
	}


	public function run()
	{
		ob_start();
		include ROOT . '/app/view/components/CustomSelect/CustomSelectTemplate.php';
		$this->html = ob_get_clean();
	}

	private function tpl($tpl,$v,$k)
	{
		$value = $v['id'] ?? $k;
		$selected = (int)$this->selected == $k ? 'selected' : '';
		$name = is_string($v) ? $v : $v[$this->optionName];

		$tpl = "<option value='{$value}' $selected>{$name}</option>";

		if (isset($v['childs'])) {
			$tpl .= $this->getChilds($v['childs'], 0);
		}
		return $tpl;
	}

	private function values()
	{
		$tpl = '';
		foreach ($this->tree as $k => $v) {

			if ($this->exclude && !in_array($v['id'], $this->exclude)) {
				$tpl .=$this->tpl($tpl,$v,$k);
			} else {
				$tpl .=$this->tpl($tpl,$v,$k);
			}
		}
		return $tpl;
	}

}