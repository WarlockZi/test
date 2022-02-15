<?php

namespace app\view\widgets\Accordion;

use app\model\Model;
use app\core\DB;
use app\core\App;

class Accordion extends Model
{
	protected $data;
	protected $tree;
	protected $menuHTML;
	protected $class = 'menu';
	protected $cache = 3600;
	protected $sql = "SELECT * FROM test";
	protected $label_after = '';
	protected $link = '/adminsc/test/';
	protected $link_label_after = '/adminsc/test/update/';


	public function __construct($options = [])
	{
		$this->getOptions($options);
		$this->run();
	}

	public function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	protected function run()
	{
		$this->data = $this->getAssoc('test');
		$this->tree = $this->hierachy();
		$this->menuHTML = $this->showCat($this->tree);
		$this->output();
	}

	protected function icon()
	{
		return $this->label_after ? file_get_contents($this->label_after) : '';
	}

	protected function lable_after($item)
	{
		if ($this->label_after) {
			return "<a class='update' href='{$this->link_label_after}{$item['id']}'>" .
				"{$this->icon()}" .
				"</a>";
		}
		return '';
	}

	function li($item, $lev)
	{
		if (isset($item['childs']) && $item['childs']) {
			return
				"<li class='has-children level{$lev}'>" .
				"<input type='checkbox' name ='group-1' id={$item['id']}>" .
				"<label for={$item['id']}>{$item['test_name']}</label>" .
				$this->lable_after($item);
		}
		return "<li>" .
			"<a data-id={$item['id']} " .
			"class='level{$lev}' " .
			"href='{$this->link}{$item['id']}' " .
			"title={$item['test_name']}>" .
			"{$item['test_name']} </a>" .
			$this->lable_after($item);
	}

	function tplMenu($item, $lev)
	{
		$menu = "{$this->li($item, $lev)}";

		if (isset($item['childs'])) {
			$menu .= '<ul>' . $this->showCat($item['childs'], $lev) . '</ul>';
		}
		$menu .= '</li>';

		return $menu;
	}

	function showCat($data, $lev = 0)
	{
		$string = '';
		$lev++;
		foreach ($data as $item) {
			$string .= $this->tplMenu($item, $lev);
		}
		return $string;
	}

	public function output()
	{
		return "<ul class = '{$this->class}'>{$this->menuHTML}</ul>";
	}

}
