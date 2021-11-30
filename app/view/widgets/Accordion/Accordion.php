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

	function li($cat)
	{
		if (isset($cat['childs'])&&$cat['childs']) {
			return
				"<li class='has-children'>" .
				"<input type='checkbox' name ='group-1' id={$cat['id']}>" .
				"<label for={$cat['id']}>{$cat['test_name']}</label>";
		}
		return "<li><a href='#' title={$cat['test_name']}>" .
		"{$cat['test_name']} </a>";
	}

	function tplMenu($category)
	{
		$menu = "{$this->li($category)}" ;

		if (isset($category['childs'])) {
			$menu .= '<ul>' . $this->showCat($category['childs']) . '</ul>';
		}
		$menu .= '</li>';

		return $menu;
	}

	function showCat($data)
	{
		$string = '';
		foreach ($data as $item) {
			$string .= $this->tplMenu($item);
		}
		return $string;
	}

	public function output()
	{
		return "<ul class = '{$this->class}'>{$this->menuHTML}</ul>";
//			"<link href='../../../../public/dist/test_edit.css'>";
	}

}
