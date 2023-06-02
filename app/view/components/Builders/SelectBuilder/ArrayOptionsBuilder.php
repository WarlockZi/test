<?php


namespace app\view\components\Builders\SelectBuilder;

use Illuminate\Database\Eloquent\Collection;

class ArrayOptionsBuilder
{
	private array $arr;
	protected int $selected=0;
	protected int $excluded=-1;
	protected string $initialOption='';

	public static function build(Collection $collection)
	{
		$arrayOptions = new self();
		$arrayOptions->arr = $collection->toArray();
		return $arrayOptions;
	}

	public function get(): string
	{
		if (!count($this->arr)&&!$this->initialOption) $this->initialOption();
		$str = $this->initialOption;
		$str .= $this->options($this->arr, '');
		return $str;
	}

	public function options($items, $string)
	{
		foreach ($items as $item) {
			$id = $item['id'];
			if ($id === $this->excluded) continue;
			$selected = $id == $this->selected ? 'selected' : '';
			$string .= "<option value = {$id} {$selected}>{$item['name']}</option>";
		}
		return $string;
	}

	public function selected(int $selected)
	{
		if ($selected) {
			$this->selected = $selected;
		}
		return $this;
	}

	public function excluded(int $excluded)
	{
		$this->excluded = $excluded;
		return $this;
	}

	public function initialOption(int $value=0, string $label=null){
		$this->initialOption = "<option value={$value}>$label</option>";
		return $this;
	}
}