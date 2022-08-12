<?php


namespace app\view\components\Builders\ItemBuilder;


use app\view\components\Builders\Builder;

class ItemTabBuilder extends Builder
{
	public $model='';
	public $html='';
	public $tabTitle='';
	public $field='';

	public static function build(string $title)
	{
		$view = new self();
		$view->tabTitle = $title;
		return $view;
	}

	public function html(string $html)
	{
		$this->html = $this->clean($html);
		return $this;
	}
	public function field(string $field)
	{
		$this->field = "data-field='{$field}'";
		return $this;
	}

	public function get()
	{
		return $this;
	}

}