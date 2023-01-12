<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Collection;

class SelectBuilder extends Builder
{
	private $tree2 = [];
	private $tree = [];

	private $array;
	private $collection;

	private $options = [];
	private $class;
	private $title;
	private $field;

	private $model;
	private $modelId;

	private $morphModel;
	private $morphId;
	private $morphSlug;
	private $morphOneOrMany;
	private $morphDetach;

	private $belongsToModel;
	private $belongsToId;

	private $selected = false;
	private $excluded = false;
	private $nameOptionByField = 'name';
	private $initialOption;

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

	public function collection(Collection $collection)
	{
		$this->collection = $collection;
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
		$this->modelId = "data-model-id='{$modelId}'";
		return $this;
	}

	public function morph(string $model,
												int $id,
												string $slug = '',
												string $oneOrMany = 'one',
												bool $detach = false)
	{
		$this->morphModel = "data-morph-model='{$model}'";
		$this->morphId = "data-morph-id='{$id}'";
		$this->morphSlug = $slug ? "data-morph-slug='{$slug}'" : "";
		$this->morphOneOrMany = "data-morph-oneOrMany='{$oneOrMany}'";
		$detach = $detach ? 'true' : 'false';
		$this->morphDetach = $detach ? "data-morph-detach='{$detach}'" : "";
		return $this;
	}

	public function belongsTo(string $model, int $id)
	{
		$this->belongsToModel = "data-belongsTo-Model='{$model}'";
		$this->belongsToId = "data-belongsTo-id='{$id}'";
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

	private function getArray(): void
	{
		$tpl = '';
		foreach ($this->array as $index => $item) {
			$selected = $this->selected === $index ? 'selected' : '';
			$tpl .= "<option value='{$index}' $selected>{$item}</option>";
		}
		$this->options = $tpl;
	}

	private function getCollection(): void
	{
		$tpl = '';
		foreach ($this->collection as $item) {
			$selected = $this->selected === $item->id ? 'selected' : '';
			$tpl .= "<option value='{$item->id}' $selected>{$item->name}</option>";
		}
		$this->options = $tpl;
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

//	private function getTree($tree, $level = 0, $str = '')
//	{
//		foreach ($tree as $k => $item) {
//			$selected = (int)$this->selected === (int)$item['id'] ? 'selected' : '';
//			$tab = str_repeat($this->tab, $level);
//
//			$str .= "<option value='{$item['id']}' $selected>{$tab}{$item[$this->nameOptionByField]}</option>";
//
//			if (isset($item['childs'])) {
//				$str .= $this->getChilds($item['childs'], $level + 1, $str);
//			}
//		}
//		return $str;
//	}

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
			$this->options = TreeBuilder::build($this->tree)->get();
		} elseif ($this->array) {
			$this->getArray();
		} else {
			$this->getCollection();
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