<?php


namespace app\view\components\Builders\SelectBuilder;


use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
//	private $tree;
//	private $relation;
//
//	private $array = [];
//	private Collection $collection;
//	private $selected;
//	private $excluded;
//
//	private $initialOption;
//
//	private $tab = '&nbsp;';
//	private $tabMultiply = 1;

	private $options='';
	private $class;
	private $title;
	private $field;

	private $model;
	private $modelId;

	private $morphFunction;
	private $morphSlug;
	private $morphOneOrMany;
	private $morphDetach;

	private $belongsToModel;
	private $belongsToId;

	public static function build(string $options)
	{
		$select = new static();
		$select->options = $options;

		return $select;
	}

	public function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}

	public function morph(string $morphFunction,
												string $slug = '',
												string $oneOrMany = 'one',
												bool $detach = false)
	{
		$this->morphFunction = "data-morph-function='{$morphFunction}'";
		$this->morphSlug = $slug ? "data-morph-slug='{$slug}'" : "";
		$this->morphOneOrMany = "data-morph-oneOrMany='{$oneOrMany}'";
		$detach = $detach ? 'true' : 'false';
		$this->morphDetach = $detach ? "data-morph-detach='{$detach}'" : "";
		return $this;
	}

	public function belongsTo(string $model, int $id)
	{
		$this->belongsToModel = "data-belongsTo-model='{$model}'";
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

	public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0)
	{
		$this->initialOption =
			"<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
		return $this;
	}

	public function get()
	{
		ob_start();
		include ROOT . '/app/view/components/Builders/SelectBuilder/SelectBuilderTemplate.php';
		$result = ob_get_clean();
		return $this->clean($result);
	}

//	public function tree(Collection $collection,
//											 string $relation,
//											 string $tab = null,
//											 int $multiply = null)
//	{
//		$this->tree = $collection;
//		$this->relation = $relation;
//		$this->tab = $tab ?? $this->tab;
//		$this->tabMultiply = $multiply ?? $this->tabMultiply;
//		return $this;
//	}
//
//	public function array(array $array)
//	{
//		$this->array = $array;
//		return $this;
//	}
//
//	public function collection(Collection $collection)
//	{
//		$this->collection = $collection;
//		return $this;
//	}

//	public function selected($selected)
//	{
//		$this->selected = $selected;
//		return $this;
//	}
//
//	public function excluded(string $excluded)
//	{
//		$this->excluded = (int)$excluded;
//		return $this;
//	}

//	private function getArray(): void
//	{
//		$tpl = '';
//		foreach ($this->array as $index => $item) {
//			$selected = $this->selected === $item['id'] ? 'selected' : '';
//			$tpl .= "<option value='{$item['id']}' $selected>{$item['name']}</option>";
//		}
//		$this->options = $tpl;
//	}
//
//	private function getCollection(): void
//	{
//		$arr = $this->collection->toArray();
//
//		foreach ($arr as $item) {
//			$selected = $this->selected === $item['id'] ? 'selected' : '';
//			$this->options .= "<option value='{$item['id']}' $selected>{$item['name']}</option>";
//		}
//
//	}


}