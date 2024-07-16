<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

use Illuminate\Database\Eloquent\Collection;

class ArrayOptionsBuilder
{
	private array $arr;
	protected int $selected = 0;
	protected $excluded = [];
	protected string $initialOption = '';
	protected $fieldsMap;

	public static function build(Collection $collection, array $fieldsMap = [])
	{
		$arrayOptions = new self();
		$arrayOptions->arr = $collection->toArray();
		$arrayOptions->fieldsMap = $fieldsMap;
		return $arrayOptions;
	}

	public function get(): string
	{
		if (!count($this->arr) && !$this->initialOption) $this->initialOption();
		$str = $this->initialOption;
		$str .= $this->options($this->arr, '');
		return $str;
	}

	public function options($items, $string)
	{
		foreach ($items as $item) {
			$id = $item['id'];
			if (in_array($id, $this->excluded)) continue;
			$selected = $id == $this->selected ? "selected" : '';
			$string .= "<option value = {$id} {$selected}>{$this->mapItems($item)}</option>";
		}
		return $string;
	}

	protected function mapItems(array $item): string
	{
		$arr = [];
		if ($this->fieldsMap) {
			$str = '';
			foreach ($item as $key => $value) {
				if (key_exists($key, $this->fieldsMap)) {
					$key = $this->fieldsMap[$key];
					$str .= "{$key}::{$value}  ";
				}
			}
		}
		if (isset($item['name'])) return $item['name'];

		return $str;
	}

	public
	function selected(int $selected)
	{
		if ($selected) {
			$this->selected = $selected;
		}
		return $this;
	}

	public
	function excluded($excluded)
	{
		if (is_numeric($excluded)) {
			$this->excluded[] = $excluded;
		} else {
			$this->excluded = $excluded;
		}
		return $this;
	}

	public
	function initialOption(int $value = 0, string $label = null)
	{
		$this->initialOption = "<option value={$value}>$label</option>";
		return $this;
	}
}