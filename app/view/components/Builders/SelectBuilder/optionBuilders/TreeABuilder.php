<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

use app\core\Error;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeBuilder;
use Illuminate\Database\Eloquent\Collection;

class TreeABuilder extends TreeBuilder
{
	private $class;
	private $href;

	public static function build(Collection $collection, string $relation, int $multiply = 1, string $tab = '&nbsp;')
	{
		$self = new self($collection, $relation, $multiply, $tab);
		return $self;
	}

	protected function getOption($item, $level): string
	{
		$id = $item['id'];
		if ($id === $this->excluded) return '';
		$selected = $id == $this->selected ? 'selected' : '';
		$this->localtab = str_repeat($this->tab, $level * $this->multiply);
		$href = "href='{$this->href}{$item['id']}'";
		return "<a data-level={$level} value={$id} {$this->class} {$href} {$selected}>{$this->localtab}{$item['name']}</a>";
	}

	protected function options($items, $level, $string)
	{
		if (!$this->href) Error::setError('добавить ссылку');
		foreach ($items as $item) {
			$string .= $this->getOption($item, $level);
			if ($item[$this->relation]) {
				$string .= $this->options($item[$this->relation], $level + 1, '');
			}
		}
		return $string;
	}

	protected function class(string $class)
	{
		$this->class = "class='{$class}'";
		return $this;
	}

	public function href(string $href)
	{
		$this->href = $href;
		return $this;
	}

}