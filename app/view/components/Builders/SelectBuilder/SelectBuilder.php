<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
	private $tree = [];
	private $class = '';
	private $title = '';
	private $field = '';
	private $model = '';
	private $selected = '';
	private $excluded = '';
	private $nameOptionByField = 'name';
	private $initialOptionValue = 0;
	private $initialOptionLabel = '';
	private $initialOption = false;

	private $tab = '&npbsp';


	public static function build(array $tree)
	{
		$select = new static();
		$select->tree = $tree;
		return $select;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}
	public function model(string $model)
	{
		$this->model = "data-model='{$model}'";
		return $this;
	}

	public function field(string $field)
	{
		$this->field = "data-field='{$field}'" ;
		return $this;
	}

	public function title(string $title)
	{
		$this->title = "title='{$title}'";
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

	public function tab($tab)
	{
		$this->tab = $tab;
		return $this;
	}

	private function isExcluded()
	{
		$tpl = '';
		foreach ($this->tree as $k => $v) {

			if ($this->excluded) {
				if ((int)$v['id'] !== (int)$this->excluded) {
					$tpl .= $this->isSelected($tpl, $v, $k);
				}
			} else {
				$tpl .= $this->isSelected($tpl, $v, $k);
			}
		}
		return $tpl;
	}
	private function isSelected($tpl, $v, $k)
	{
		$value = $v['id'] ?? $k;
		$selected = (int)$this->selected === (int)$v['id']? 'selected' : '';
		$name = is_string($v) ? $v : $v[$this->nameOptionByField];

		$tpl = "<option value='{$value}' $selected>{$name}</option>";

		if (isset($v['childs'])) {
			$tpl .= $this->getChilds($v['childs'], 0);
		}
		return $tpl;
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

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

//	public function getOption($item, $level)
//	{
//		ob_start();
//		include $this->finalTpl;
//		return ob_get_clean();
//	}

}