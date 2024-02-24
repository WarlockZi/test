<?php


<<<<<<< HEAD
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
	public function attachButtonAfter(string $file)
	{
		$this->attachAfter = $this->attachAfter.FS::getFileContent($file);
		return $this;
=======
namespace app\view\Accordion\Admin;


use app\core\Icon;
use app\model\User;

class SidebarBuilder
{
	private $user;
	private $class = '';
	private $item;
	private $title;
	private $icon;
	private $arrow;
	private $header;
	private $ul = '';

	private $items = '';

	public static function build(array $user)
	{
		$sidebar = new self;
		$sidebar->user = $user;
		return $sidebar;
>>>>>>> e42d4fff530713125942886f16c882efcf4e99e7
	}

	public function class(string $class)
	{
<<<<<<< HEAD
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
	public function get()
	{
		$res = '';
		foreach ($this->items as $item) {
			$res .= $this->getLi($item, 0);
		}
		return "		<div class='accordion_wrap{$this->class}'><ul accordion class='{$this->class}'>$res</ul>{$this->attachAfter}</div>";
=======
		$this->class = " class = '{$class}'";
		return $this;
	}

	public function item(array $item)
	{
		$this->item = $item;
		if ($this->checkRights()) {
			$this->title = $this->setTitle();
			$this->icon = $this->setIcon();
			$this->arrow = $this->setArrow();

			$this->header = $this->setHeader();

			$this->ul = $this->setUl();

			$this->items .= $this->header . $this->ul;

		}

		return $this;
	}

	public function get()
	{
		return "<ul {$this->class}>{$this->items}</ul>";

	}

	private function checkRights(): bool
	{
		if (isset($this->item['rights'])) {
			if (User::can($this->user, $this->item['rights'])) {
				return true;
			}
			return false;
		}
		return true;
	}

	private function setTitle(): string
	{
		if (isset($this->item['header']['title'])) {
			return $this->item['header']['title'];
		}
		return '';
	}

	private function setIcon()
	{
		if (isset($this->item['header']['icon'])) {
			$icon = $this->item['header']['icon'];
			return Icon::$icon('admin-menu');
		}
		return '';
	}

	private function setArrow()
	{
		if (isset($this->item['header']['arrow'])) {
			return "<span class='arrow'></span>";
		}
		return '';
	}

	private function setHeader()
	{
		return $this->arrow . $this->icon . $this->title;
	}

	private function setUl()
	{
		if (isset($this->item['ul'])) {
			$ul = '';
			foreach ($this->item['ul'] as $item) {
				$ul .= "<li><a class='neon' href='{$item[0]}'>{$item[1]}</a></li>";
			}
			return "<ul>{$ul}</ul>";
		}
		return '';
>>>>>>> e42d4fff530713125942886f16c882efcf4e99e7
	}

}