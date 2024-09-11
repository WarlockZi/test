<?php


namespace app\view\components\Builders\ItemBuilder;


use app\view\components\Traits\CleanString;

class ItemTabBuilder
{
    use CleanString;
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

	public function html(string $html):static
	{
		$this->html = $this->clean($html);
		return $this;
	}
}