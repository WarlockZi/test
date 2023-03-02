<?php


namespace app\view\components\Builders\SelectBuilder;

use app\core\Error;
use Illuminate\Database\Eloquent\Collection;

class TreeBuilder
{
	private array $arr;
	private string $relation;

	private int $selected;
	private int $excluded;

	private $localtab;
	private $tab;
	private $tabMultiply;

	public static function build(Collection $collection,
															 string $relation,
															 string $tab = '&nbsp;',
															 int $multiply = 1)
	{
		$self = new self();
		$self->arr = $collection->toArray();
		$self->relation = $relation;
		$self->validateFormat();

		$self->tabMultiply = $multiply;
		$self->tab = $tab;

		return $self;
	}

	public function selected(int $selected)
	{
		$this->selected = $selected;
		return $this;
	}

	public function excluded(int $excluded)
	{
		$this->excluded = $excluded;
		return $this;
	}

	protected function getOption($item, $level): string
	{
		$id = $item['id'];
		if ($id=== $this->excluded) return '';
		$selected = $id == $this->selected ? 'selected' : '';
		$this->localtab = str_repeat($this->tab, $level * $this->tabMultiply);
		return "<option data-level={$level} value = '{$id}' {$selected}>{$this->localtab}{$item['name']}</option>";
	}

	protected function options($items, $level, $string)
	{
		foreach ($items as $item) {
			$string .= $this->getOption($item, $level);
			if ($item[$this->relation]) {
				$string .= $this->options($item[$this->relation], $level + 1, '');
			}
		}
		return $string;
	}

	protected function validateFormat()
	{
		$first = $this->arr[0];
		if (!isset($first['id']) || !isset($first['name'])) Error::setError('no name or id');
		if (!isset($first[$this->relation])) Error::setError('no relation');
	}

	public function get()
	{
		$str = $this->options($this->arr, 0, '');
		return $str;
	}

}