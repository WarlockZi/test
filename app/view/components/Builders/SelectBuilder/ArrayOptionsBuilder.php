<?php


namespace app\view\components\Builders\SelectBuilder;

use Illuminate\Database\Eloquent\Collection;

class ArrayOptionsBuilder
{
	private array $arr;
	protected $selected;
	protected $excluded;
	protected $initialOption;

	public static function build(Collection $collection)
	{
		$arrayOptions = new self();
		$arrayOptions->arr = $collection->toArray();
		return $arrayOptions;
	}

	public function get(): string
	{
		$str = $this->initialOption;
		$str .= $this->options($this->arr, 0, '');
		return $str;
	}

	protected function getOption($item, $level): string
	{
		$id = $item['id'];
		if ($id === $this->excluded) return '';
		$selected = $id == $this->selected ? 'selected' : '';
		return "<option value = {$id} {$selected}>{$item['name']}</option>";
	}

	public function options($items, $level, $string)
	{
		foreach ($items as $item) {
			$string .= $this->getOption($item, $level);
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
}