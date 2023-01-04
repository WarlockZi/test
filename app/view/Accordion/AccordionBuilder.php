<?php


namespace app\view\Accordion;


use Illuminate\Database\Eloquent\Collection;

class AccordionBuilder
{
	protected $items;
	protected $modelName;
	protected $modelShortName;
	protected $parentName;

	protected $ulBefore;
	protected $ulAfter;
	protected $liBefore;
	protected $liAfter;

	public static function build(
		Collection $items,
		string $link
	)
	{
		$accordion = new self;
		$accordion->items = $items;

		$reflect = new \ReflectionClass($items);
		$accordion->modelShortName = lcfirst($reflect->getShortName());
		$accordion->modelName = get_class($items);

		$accordion->link = $link;

		return $accordion;
	}


	public function parentName(string $parentName)
	{
		$this->parentName = $parentName;
		return $this;
	}

	public function ulBefore(string $ulBefore)
	{
		$this->ulBefore = $ulBefore;
		return $this;
	}

	public function ulAfter(string $ulAfter)
	{
		$this->ulAfter = $ulAfter;
		return $this;
	}
	public function liBefore(string $liBefore)
	{
		$this->liBefore = $liBefore;
		return $this;
	}

	public function liAfter(string $liAfter)
	{
		$this->liAfter = $liAfter;
		return $this;
	}

	public function get()
	{
		$res = '';
		foreach ($this->items as $item) {
			if ($item->$rel) {
				$res .= $this->getUl($item, $rel);
			} else {
				$li = '';
			}
		}
		return 'accordion';
	}

	protected function getUl($item, $rel)
	{
		return "<ul>{$this->ulBefore}dddd{$this->ulAfter}</ul>";
	}

}