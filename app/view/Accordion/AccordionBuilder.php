<?php


namespace app\view\Accordion;


use app\core\FS;
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

	protected $liBefore = ['icon' => '', 'link' => ''];
	protected $liAfter = ['icon' => '', 'link' => ''];

	protected $ulBefore = ['icon' => '', 'link' => ''];
	protected $ulAfter = ['icon' => '', 'link' => ''];

	protected $isPathAttr = '';
	protected $attachAfter;

	public static function build(Collection $items,string $link)
	{
		$accordion = new self;
		$accordion->items = $items->toArray();
		$accordion->link = $link;

        $accordion->modelName = get_class($items);

		$reflect = new \ReflectionClass($items);
		$accordion->modelShortName = lcfirst($reflect->getShortName());
		return $accordion;
	}

	public function relation(string $name)
	{
		$this->relation = $name;
		return $this;
	}
	public function attachButtonAfter(string $file)
	{
		$this->attachAfter = $this->attachAfter.FS::getFileContent($file);
		return $this;
	}

	public function class(string $class)
	{
		$this->class = ' '.$class;
		return $this;
	}

	protected function setLi($name, $icon, $link = '')
	{
		$this->$name['icon'] = $icon ;
		$this->$name['link'] = $link;
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
		$before = $this->getBeforeAfter('li','before', $ul);
		$after = $this->getBeforeAfter('li','after', $ul);
		$body = "<a href='{$this->link}{$ul['id']}'>{$before}<tag>{$ul['name']}</tag></a>";
		if (count($ul[$this->relation]) || !$ul[$this->isPathAttr]) {
			$before = $this->getBeforeAfter('ul','before', $ul);
			$after = $this->getBeforeAfter('ul','after', $ul);
			$body = "<span>{$before}<tag>{$ul['name']}</tag></span>";
			$uls .= $this->getUl($ul[$this->relation], ++$level);
		}
		return "<li><label>$body{$after}</label>{$uls}</li>";
	}

	private function getBeforeAfter(string $tag, string $place, $ul):string
	{
		$tag .= ucfirst($place);
		$icon = $this->$tag['icon'];
		if ($this->$tag['link']){
			$link = $this->$tag['link']."{$ul['id']}";
			return "<a href='{$link}'>{$icon}</a>";
		}else{
			return "<div class='before'>{$icon}</div>";
		}
	}
	public function get(): string
    {
		$res = '';
		foreach ($this->items as $item) {
			$res .= $this->getLi($item, 0);
		}
		return "<div class='accordion_wrap test-accordion{$this->class}'><ul accordion class='{$this->class}'>$res</ul>{$this->attachAfter}</div>";
	}

}