<?php

namespace app\view\widgets\Accordion;

use app\model\Model;

class Accordion extends Model
{
	public $models=[];
	protected $parentFieldName = '';
//	protected $data;
//	protected $tree;
	protected $html;
	protected $class = '';

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
		$models = $this->getAssoc2($this->models);
		$this->tree = $this->hierachy2($models, $this->parentFieldName);
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
		ob_start();
//		$isTest = $item['isTest'] === '1' ? 'data-istest' : '';
		include ROOT."/app/view/widgets/Accordion/li.php";
		return ob_get_clean();
	}

	function tplMenu($item, $lev)
	{
		$childs = isset($item['childs']);
		$class = $childs?"class='childs'":'' ;

		$menu = "<li {$class}>";
		$menu .= "{$this->li($item, $lev)}";

		if ($childs) {
			$menu .= "<ul  class='level-{$lev}'>" . $this->showCat($item['childs'], $lev) . '</ul>';
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
