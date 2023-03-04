<?php


namespace app\view\components\Builders\SelectBuilder;

use Illuminate\Database\Eloquent\Collection;

class TreeOptionsBuilder extends TreeBuilder
{
	private $tag = 'option';

	public static function build(Collection $collection,
															 string $relation,
															 int $multiply = 1,
															 string $tab = '&nbsp;')
	{
		$self = new self($collection, $relation, $multiply, $tab);
		return $self;
	}

	protected function getOption($item, $level): string
	{
		$id = $item['id'];
		if ($id === $this->excluded) return '';
		$selected = $id == $this->selected ? 'selected' : '';
		$this->localtab = str_repeat($this->tab, $level * $this->tabMultiply);
		return "<option data-level={$level} value = {$id} {$selected}>{$this->localtab}{$item['name']}</option>";
	}

	public function options($items, $level, $string)
	{
		foreach ($items as $item) {
			$string .= $this->getOption($item, $level);
			if ($item[$this->relation]) {
				$string .= $this->options($item[$this->relation], $level + 1, '');
			}
		}
		return $string;
	}

	public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0)
	{
		$this->initialOption =
			"<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
		return $this;
	}
}