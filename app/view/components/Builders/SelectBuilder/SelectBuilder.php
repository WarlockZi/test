<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
	private $tree2 = [];
	private $tree = [];
	private $array = [];
	private $options = [];
	private $class = '';
	private $title = '';
	private $field = '';
	private $model = '';
	private $modelId = '';
	private $selected = false;
	private $excluded = false;
	private $nameOptionByField = 'name';
	private $initialOption = '';

	private $tab = '&nbsp;';

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

	public function tree2($tree)
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

	public function modelId($modelId)
	{
		$this->modelId = "data-id='{$modelId}'";
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
		$this->selected = $selected;
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
			$selected = $this->selected === $index ? 'selected' : '';
			$tpl .= "<option value='{$index}' $selected>{$item}</option>";
		}
		return $tpl;
	}

	protected function getTree2($data, $level = 0)
	{
		$string = '';
		foreach ($data as $item) {
			$string .= $this->addItem($item, $level);
		}
		return $string;
	}

	private function addItem($item, $level)
	{
		$tab = str_repeat($this->tab, $level);
		$selected = (int)$item['id'] === (int)$this->selected
			? 'selected'
			: '';
		$menu = "<option value='{$item['id']}' {$selected}>{$tab}{$item['name']}</option>";
		if (isset($item['childs'])) {
			$menu .= "{$this->getTree2($item['childs'],$level+1)}";
		}
		return $menu;
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

	protected function getChilds(array $tree, $level, $str)
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
		if ($this->tree) {
//			$this->options = $this->getTree2($this->tree);
			$this->options = TreeBuilder::build($this->tree)->get();
		} else {
			$this->options = $this->getArray();
		}

		if ($this->excluded !== false) {
			unset($this->tree[$this->excluded]);
		}

		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

}