<?php


namespace app\view\components\Builders\MyAccordion;


use app\view\components\Builders\Builder;

class MyAccordion extends Builder
{
	public $model;
	public $tree;
	public $class;
	public $labelAfter;
	public $labelBefore;
	public $link;
	public $parentFieldName;
	public $nameFieldName = 'name';
	public $html;
	public $signOfParent;
	public $signOfChild;

	public static function build(array $tree)
	{
		$accordion = new self();
		$accordion->tree = $tree;
		return $accordion;
	}

	public function model($model)
	{
		$this->model = $model;
		return $this;
	}

	public function class($class)
	{
		$this->class = $class;
		return $this;
	}

	public function link($link)
	{
		$this->link = $link;
		return $this;
	}

	public function signOfChild($signOfChild)
	{
		$this->signOfChild = $signOfChild;
		return $this;
	}

	public function signOfParent($signOfParent)
	{
		$this->signOfParent = $signOfParent;
		return $this;
	}

	public function parentFieldName($parentFieldName)
	{
		$this->parentFieldName = $parentFieldName;
		return $this;
	}

	public function nameFieldName($nameFieldName)
	{
		$this->nameFieldName = $nameFieldName;
		return $this;
	}

	public function get(): string
    {
		$this->showCat($this->tree);
		$html = $this->make();

		return $html;
	}

	public function first($arrowBefore)
	{
		$this->arrowBefore = $arrowBefore;
		return $this;
	}

	public function second($labelBefore)
	{
		$this->labelBefore = $labelBefore;
		return $this;
	}

	public function labelMiddleHtml($labelMiddleHtml)
	{
		$this->labelMiddleHtml = $labelMiddleHtml;
		return $this;
	}

	public function labelAfter($labelAfter)
	{
		$this->labelAfter = file_get_contents($labelAfter);
		return $this;
	}

	public function labelAfterLink(string $labelAfterLink)
	{
		$this->labelAfter =
			"<a href='$this->labelAfterLink'>$this->labelAfter</a>";
		return $this;
	}

	protected function makeString()
	{
		"<li>" .
		"{$this->first}" .
		"{$this->second}" .
		"{$this->main}" .
		"{$this->after}" .
		"<ul>".

		"</ul>".
		"</li>";

	}

	protected function lable_after($item)
	{
		if ($this->link_label_after) {
			return "<a class='update' 
href='{$this->link_label_after}{$item['id']}'>" .
				"{$this->labelAfter}" .
				"</a>";
		}

	}

	private function make()
	{
		return "<div accordion class='{$this->class}'>{$this->html}</div>";
	}


	function li($item, $lev)
	{
		ob_start();
		include ROOT . "/app/view/widgets/Accordion/li.php";
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
}

