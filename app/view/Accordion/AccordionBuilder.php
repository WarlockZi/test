<?php


namespace app\view\Accordion;


use app\core\Icon;
use Illuminate\Database\Eloquent\Collection;

class AccordionBuilder
{
	protected $items;
	protected $modelName;
	protected $modelShortName;
	protected $link;
	protected $parentName;

	protected $relation;
	protected $class;

	protected $liBefore = '';
	protected $liAfter = '';

	protected $ulBefore = '';
	protected $ulAfter = '';

	protected $isPathAttr = '';

	public static function build(
		Collection $items,
		string $link
	)
	{
		$accordion = new self;
		$accordion->items = $items->toArray();

		$reflect = new \ReflectionClass($items);
		$accordion->modelName = get_class($items);
		$accordion->modelShortName = lcfirst($reflect->getShortName());

		$accordion->link = $link;

		return $accordion;
	}

	public function relation(string $name)
	{
		$this->relation = $name;
		return $this;
	}

	public function class(string $name)
	{
		$this->class = $name;
		return $this;
	}

	protected function setLi($name, $icon, $link)
	{
		$icon = Icon::$icon() ? Icon::$icon() : $icon;
		if ($link) {
			$this->$name = "<a href='{$link}'>{$icon}</a>";
		} else {
			$this->$name = "<div class='before'>{$icon}</div>";
		}
	}

	public function liAfter(string $icon, string $link = '')
	{
		$this->setLi('liAfter', $icon, $link);
		return $this;
	}

	public function isPathAttr(string $isPathAttr)
	{
		$this->isPathAttr = $isPathAttr;
		return $this;
	}

	public function liBefore(string $icon, string $link = '')
	{
		$this->setLi('liBefore', $icon, $link);
		return $this;
	}

	public function ulAfter(string $icon, string $link = '')
	{
		$this->setLi('ulAfter', $icon, $link);
		return $this;
	}

	public function ulBefore(string $icon, string $link = '')
	{
		$this->setLi('ulBefore', $icon, $link);
		return $this;
	}

	protected function getUl($ul, int $level)
	{
		$lis = '';
		foreach ($ul as $li) {
			$lis .= $this->getLi($li, $level);
		}
		return "<ul class='level-{$level}'>{$lis}</ul>";
	}

	protected function getLi($ul, int $level)
	{
		$uls = '';
		$before = $this->liBefore;
		$after = $this->liAfter;
		$body = "<a href='{$this->link}{$ul['id']}'>{$before}<tag>{$ul['name']}</tag></a>";
		if (count($ul[$this->relation])||!$ul[$this->isPathAttr]) {
			$before = $this->ulBefore;
			$after = $this->ulAfter;
			$body = "<span>{$before}<tag>{$ul['name']}</tag></span>";
			$uls .= $this->getUl($ul[$this->relation], ++$level);
		}
		return "<li><label>$body{$after}</label>{$uls}</li>";
	}

	public function get()
	{
		$res = '';
		foreach ($this->items as $item) {
			$res .= $this->getLi($item, 0);
		}
		return "<ul accordion class='{$this->class}'>$res</ul>";
	}


}