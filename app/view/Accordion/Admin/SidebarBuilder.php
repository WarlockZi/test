<?php


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
	}

	public function class(string $class)
	{
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
	}

}