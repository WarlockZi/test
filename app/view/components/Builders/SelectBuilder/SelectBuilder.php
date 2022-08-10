<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
	private $tree = [];
	private $array = [];
	private $class = '';
	private $title = '';
	private $field = '';
	private $model = '';
	private $selected = false;
	private $excluded = false;
	private $nameOptionByField = 'name';
	private $initialOption = '';

	private $tab = '&npbsp';


	public static function build()
	{
		$select = new static();
		return $select;
	}

	public function tree($tree)
	{
		$this->tree = $tree;
		return $this;
	}

	public function array(array $array)
	{
		$this->array = $array;
		return $this;
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
		$this->field = "data-field='{$field}'";
		return $this;
	}

	public function title(string $title)
	{
		$this->title = "title='{$title}'";
		return $this;
	}


	public function initialOption(string $initialOptionLabel, int $initialOptionValue)
	{
		$this->initialOption =
			"<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
		return $this;
	}

	public function nameOptionByField(string $nameOptionByField)
	{
		$this->nameOptionByField = $nameOptionByField;
		return $this;
	}

	public function selected($selected)
	{
		$this->selected = (int)$selected;
		return $this;
	}

	public function excluded(string $excluded)
	{
		$this->excluded = (int)$excluded;
		return $this;
	}

	public function tab(string $tab)
	{
		$this->tab = $tab;
		return $this;
	}

	private function getArray()
	{
		$tpl = '';
		foreach ($this->array as $index => $item) {
			$selected = (int)$this->selected === $index ? 'selected' : '';
			$tpl .= "<option value='{$index}' $selected>{$item}</option>";
		}
		return $tpl;
	}

	private function getTree($tree, $level = 0, $str = '')
	{
		foreach ($tree as $k => $item) {
			$selected = (int)$this->selected === (int)$item['id'] ? 'selected' : '';
			$tab = str_repeat($this->tab, $level);

			$str .= "<option value='{$item['id']}' $selected>{$tab}{$item[$this->nameOptionByField]}</option>";

			if (isset($item['childs'])) {
				$str .= $this->getChilds($item['childs'], $level + 1, $str);
			}
		}
		return $str;
	}

	public function getChilds(array $tree, $level, $str)
	{
		foreach ($tree as $id => $item) {
			$selected = (int)$this->selected === (int)$item['id'] ? 'selected' : '';
			$tab = str_repeat($this->tab, $level);
			$str .= "<option value='{$item['id']}' $selected>{$tab}{$item[$this->nameOptionByField]}</option>";

			if (isset($item['childs'])) {
				$str .= $this->getChilds($item['childs'], $level + 1, $str);
			}
		}
		return $str;
	}

	public function get()
	{
		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}

		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

}