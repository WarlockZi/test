<?php

namespace app\view\Accordion;


use app\view\components\MyTree;

class AccordionDel
{
	public $models = [];
	public $model;
	protected $parentFieldName = '';
	public $html;
	protected $tree;
	protected $class = '';
	protected $label_after = '';
	protected $link_label_after = ''; // /adminsc/test/update/
	protected $link = '';

	protected function run()
	{
		$str = '';
		$level = 0;
		foreach ($this->models as $model) {
			$str .= $this->getLi($model, $level);
			if (!isset($model[$this->parentFieldName])) {
				$str .= $this->getLi($model, $level);
			} else {
				$str .= $this->getUl($model, $level);
			}
		}
		$this->html = $str;
//		$this->html = $this->showCat($model);
//		$this->tree = MyTree\Tree::tree($this->models, $this->parentFieldName);
//		$this->html = $this->showCat($this->tree);
		$this->output();
	}

	protected function getLi(array $item, int $level)
	{
		$str = '';
		if (isset($item[$this->parentFieldName])){
			$str.=$this->getUl($item[$this->parentFieldName],$level++);
		}
		return "<li>{$this->li($item, $level)}{$str}</li>";
//		return $this->li($item, $level);
	}

	protected function getUl(array $items, int $level)
	{
		$str = '';
		foreach ($items[$this->parentFieldName] as $item) {
			$str .= self::getLi($item,$level);
		}
		return "<ul class='level-{$level}'>{$str}</ul>";
//		return "<ul  class='level-{$level}'>" . $this->showCat($items[$this->parentFieldName], $level) . '</ul>';
//		return "<ul>{$item['name']}{$str}</ul>";
	}

	protected function run2()
	{
		$this->tree = MyTree\Tree::build($this->models)
			->parent($this->parentFieldName)
			->get();
		$this->html = $this->showCat($this->tree);
		$this->output();
	}

	function li($item, $lev)
	{
		ob_start();
		include ROOT . "/app/view/Accordion/li.php";
		return ob_get_clean();
	}

	function tplMenu($item, $lev)
	{
		$childs = isset($item['childs']);
		$class = $childs ? "class='childs'" : '';

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

	public function output(): void
	{
		$this->html = "<div accordion class = '{$this->class}'>{$this->html}</div>";
	}

	public function getHtml()
	{
		return $this->html;
	}
	public function __construct($options = [])
	{
		$this->getOptions($options);
		if (!$this->link) {
			$this->link = "/adminsc/{$this->model->model}/update/";
		}
		$this->run();
	}

	public function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
		$this->label_after = $this->label_after ? file_get_contents($this->label_after) : '';
	}

//	protected function icon()
//	{
//		return ;
//	}

	protected function lable_after($item)
	{
		if ($this->link_label_after) {
			return "<a class='update' href='{$this->link_label_after}{$item['id']}'>" .
				"{$this->label_after}" .
				"</a>";
		}
		return '';
	}
}
