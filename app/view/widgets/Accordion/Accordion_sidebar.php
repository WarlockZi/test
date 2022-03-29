<?php

namespace app\view\widgets\Accordion;

class Accordion_sidebar
{
//	protected $data;
	protected $tree;
	protected $menuHTML;
	protected $class = 'menu';
	protected $cache = 3600;

//	protected $sql = "SELECT * FROM test";

	public function __construct($options = [])
	{
		$this->getOptions($options);
		$this->run();
	}

	private function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	protected function run()
	{
		$this->tree = $this->getAssoc();
		$this->menuHTML = $this->showCat(0,$this->tree);
		$this->output();
	}

	protected function li($i, $item, $lev)
	{
		if (is_array($item)) {
			return
				"<li level{$lev}'>" .
				"<input type='checkbox' name ='group-1' id={$i}>" .
				"<label for={$i}>{$i}</label>" .
				"";
		}
		return "<li><a data-id={$i} class='level{$lev}' href='/adminsc/test/edit/{$i}' title={$i}>" .
			"{$i} </a>";
	}

	protected function tplMenu($i, $item, $lev)
	{
		$menu = "{$this->li($i, $item, $lev)}";

		if (is_array($item)) {
			$menu .= '<ul>' . $this->showCat($i, $item, $lev) . '</ul>';
		}
		$menu .= '</li>';

		return $menu;
	}

	protected function showCat($i, $data, $lev = 0)
	{
		$string = '';
		$lev++;
		foreach ($data as $i=>$item) {
			$string .= $this->tplMenu($i, $item, $lev);
		}
		return $string;
	}

	public function output()
	{
		return "<ul class = '{$this->class}'>{$this->menuHTML}</ul>";
	}

	private function getAssoc()
	{
		return [
			"Главный" => [
				"Каталог",
				"Настройки",
				"CRM",
				"Тесты"
			],
			"Каталог" => [
				"Каталог",
				"Настройки",
				"CRM",
				"Тесты"
			],
			"Настройки" => [
			],
			"CRM" => [
			],
			"Тесты" => [
			],
		];

	}

}
