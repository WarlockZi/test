<?php

namespace app\view\Accordion;


class delAccordion
{
	protected $models = [];

	protected $childName ;
	protected $tree;
	protected $class = '';
	protected $label_after = '';
	protected $link_label_after = ''; // /adminsc/test/update/
	protected $link = '';
	public $html;

	protected function run()
	{
		$str = '';
		$level = 0;
		foreach ($this->models as $model) {
			$str .= $this->getLi($model, $level);
		}
		$this->html = $str;

	}

	protected function getLi(array $item, int $level)
	{
		$ul = '';
		$hasChild = isset($item[$this->childName]) && count($item[$this->childName]);
		if ($hasChild) {
			$ul .= $this->getUl($item[$this->childName], ++$level);
		}
		return "<li>{$this->li($item, $level)}{$ul}</li>";
	}

	protected function getUl(array $items, int $level)
	{
		$str = '';
		$hasChild = isset($items[$this->childName]) && count($items[$this->childName]);
		if ($hasChild) {
			foreach ($items[$this->childName] as $item) {
				$str .= self::getLi($item, $level++);
			}
		} else {
			foreach ($items as $item) {
				$str .= self::getLi($item, $level);
			}
		}
		return "<ul class='level-{$level}'>{$str}</ul>";
	}

	function li($item, $lev)
	{
		ob_start();
		include ROOT . "/app/view/Accordion/li.php";
		return ob_get_clean();
	}

	public function getHtml()
	{
		return "<div accordion class = '{$this->class}'>{$this->html}</div>";
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

	protected function lable_after($item)
	{
		if ($this->link_label_after) {
			return "<a class='update' href='{$this->link_label_after}{$item['id']}'>{$this->label_after}</a>";
		}
		return '';
	}

}
