<?php


namespace app\view\Accordion;


use Illuminate\Database\Eloquent\Collection;

class AccordionBuilder
{

	protected $items;
	protected $modelName;
	protected $modelShortName;
	protected $relation;

	public static function build(Collection $items, string $relation)
	{
		$accordion = new self;
		$reflect = new \ReflectionClass($items);
		$accordion->modelShortName = lcfirst($reflect->getShortName());
		$accordion->modelName = get_class($items);

		$accordion->items = $items;
		$accordion->relation = $relation;

		return $accordion;
	}

	public function get()
	{
		$res = '';
		$rel = $this->relation;
		foreach ($this->items as $item) {
			if ($item->$rel) {
				$res .= $this->getUl($item, $rel);
			} else {
				$li = '';
			}
		}
		return 'accorion';
	}

	protected function getUl($item, $rel)
	{
//		$it = $item->$rel;
//		$ul = '';
		return '<ul>dddd</ul>';
	}

}