<?php

namespace app\view\widgets\Accordion;

use app\model\Model;

class Accordion extends Model
{
	public $model;
	protected $data;
	protected $tree;
	protected $html;
	protected $class = 'accordion';
	protected $nameFieldName = 'test_name';
	protected $parentFieldName = 'parent';
	protected $cache = 3600;
	protected $sql = "SELECT * FROM test";
	protected $label_after = '';
	protected $link = '/adminsc/test/';
	protected $link_label_after = '/adminsc/test/update/';


	public function __construct($options = [])
	{
		parent::__construct();
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
		$this->data = $this->getAssoc();
		$this->tree = $this->hierachy($this->parentFieldName);
		$this->html = $this->showCat($this->tree);
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
		if (!$item['isTest']) {
			return
				"<li class='has-children level{$lev}'>" .
				"<input type='checkbox' name ='group-1' id={$item['id']}>" .
				"<label for={$item['id']}>{$item[$this->nameFieldName]}</label>" .
				$this->lable_after($item);
		}
		$isTest = $item['isTest']==='1' ? '' : 'data-istest';
		return "<li>" .
			"<a data-id={$item['id']} " .
			"class='level{$lev}' " .
			"href='{$this->link}{$item['id']}' " .
			"title={$item[$this->nameFieldName]} {$isTest}>" .
//			"title={$item[$this->nameFieldName]} {$isTest}>" .
			"{$item[$this->nameFieldName]} </a>" .
//			"{$item[$this->nameFieldName]} </a>" .
			$this->lable_after($item);
	}

	function tplMenu($item, $lev)
	{
		$menu = "{$this->li($item, $lev)}";

		if (isset($item['childs'])) {
			$menu .= "<ul>" . $this->showCat($item['childs'], $lev) . '</ul>';
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
		return "<ul accordion class = '{$this->class}'>{$this->html}</ul>";
	}

}
