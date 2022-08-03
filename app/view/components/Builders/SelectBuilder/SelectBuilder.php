<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
	private $item = '';
	private $class = '';
	private $title = '';
	private $nameOptionByField = 'name';
	private $field = '';
	private $selected = '';
	private $excluded = '';
	private $initialOptionValue = 0;
	private $initialOptionLabel = '';
	private $initialOption = false;

	private $tree = [];
	private $tab = '&npbsp';

	private $finalTpl = ROOT . '/app/view/components/Builders/SelectBuilder/tpl.php';

	public static function build(array $item)
	{
		$select = new static();
		$select->item = $item;
		return $select;
	}

	public function class(string $class)
	{
		$this->class = $class;
		return $this;
	}

	public function field(string $field)
	{
		$this->field = $field;
		return $this;
	}

	public function selected($selected)
	{
		$this->selected = $selected;
		return $this;
	}

	public function initialOptionLabel(string $initialOptionLabel, int $initialOptionValue)
	{
		$this->initialOption = true;
		$this->initialOptionLabel = $initialOptionLabel;
		$this->initialOptionValue = $initialOptionValue;
		return $this;
	}

	public function initialOptionValue(string $initialOptionValue)
	{
		$this->initialOptionValue = $initialOptionValue;
		return $this;
	}

	public function title(string $title)
	{
		$this->title = $title;
		return $this;
	}

	public function nameOptionByField(string $nameOptionByField)
	{
		$this->nameOptionByField = $nameOptionByField;
		return $this;
	}

	public function excluded(string $excluded)
	{
		$this->excluded = $excluded;
		return $this;
	}

	public function tree(array $tree)
	{
		$this->tree = $tree;
		return $this;
	}

	public function tab($tab)
	{
		$this->tab = $tab;
		return $this;
	}

	public function getChilds($tree, $level)
	{
		$str = '';
		foreach ($tree as $id => $item) {
			$str .= $this->getOption($item, $level + 1);
			if (isset($item['childs'])) {
				$str .= $this->getChilds($item['childs'], $level + 1);
			}
		}
		return $str;
	}

	public function getOption($item, $level)
	{
		ob_start();
		include $this->finalTpl;
		return ob_get_clean();
	}

	private function tpl($tpl, $v, $k)
	{
		$value = $v['id'] ?? $k;
		$selected = (int)$this->selected === (int)$k
			? 'selected' : '';
		$name = is_string($v) ? $v : $v[$this->nameOptionByField];

		$tpl = "<option value='{$value}' $selected>{$name}</option>";

		if (isset($v['childs'])) {
			$tpl .= $this->getChilds($v['childs'], 0);
		}
		return $tpl;
	}

	private function options()
	{
		$tpl = '';
		foreach ($this->tree as $k => $v) {

			if ($this->excluded) {
				if ($v['id'] !== $this->excluded) {
					$tpl .= $this->tpl($tpl, $v, $k);
				}
			} else {
				$tpl .= $this->tpl($tpl, $v, $k);
			}
		}
		return $tpl;
	}



	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

}