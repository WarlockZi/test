<?php


namespace app\view\components\Builders\SelectBuilder;

use Illuminate\Database\Eloquent\Collection;

class TreeBuilder
{

	private $collection;
	private $relation;

	private $selected;

	private $tab = '&nbsp;';
	private $tabMultiply = 1;

	public static function build(Collection $collection,
															 string $relation,
															 string $tab = null,
															 int $multiply = null)
	{
		$self = new self();
		$self->collection = $collection;
		$self->relation = $relation;
		$self->tab = $tab ?? $self->tab;
		$self->tabMultiply = $multiply ?? $self->tabMultiply;

		return $self;
	}

	public function selected(int $selected)
	{
		$this->selected = $selected;
		return $this;
	}

	protected function getOption($item, $level)
	{
		$selected = $item->id== $this->selected?'selected':'';
		$tab = str_repeat($this->tab, $level * $this->tabMultiply);
		return "<option data-level={$level} {$selected}>{$tab}{$item->name}</option>>";
	}

	protected function recursion($collection, $level, $string)
	{
		foreach ($collection as $item) {
			$string .= $this->getOption($item, $level);
			if ($item->{$this->relation}) {
				$string .= $this->recursion($item->{$this->relation}, $level + 1, '');
			}
		}
		return $string;
	}

	public function get()
	{
		$str = $this->recursion($this->collection, 0, '');
		return $str;
	}

}