<?php


namespace app\view\components\MySelect;


class MySelect
{
	private $field = '';
	private $class = '';
	private $tab = '- ';
	private $title = '';
	private $tree = [];
	private $selected = 0;
	private $exclude = [];
	private $optionName = 'name';

	private $initialOptionValue = 0;
	private $initialOptionLabel = null;
	private $type = 'string';

	private $finalTpl = ROOT . '/app/view/components/CustomSelect/tpl.php';
	public $html;

	public function __construct($options)
	{
		$this->getOptions($options);
		$this->run();
	}

	private function run()
	{
		ob_start();
		include ROOT . '/app/view/components/CustomSelect/CustomSelectTemplate.php';
		$this->html = ob_get_clean();
	}

	private function tpl($tpl, $v, $k)
	{
		$value = $v['id'] ?? $k;
		$selected = (int)$this->selected[0] === (int)$k
			? 'selected' : '';
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

			if ($this->exclude) {
				if ($v['id'] !== $this->exclude) {
					$tpl .= $this->tpl($tpl, $v, $k);
				}
			} else {
				$tpl .= $this->tpl($tpl, $v, $k);
			}
		}
		return $tpl;
	}

}