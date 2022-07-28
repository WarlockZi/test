<?php


namespace app\view\components\Builders\Item;


class ItemTabBuilder
{
	protected $model;
	protected $html;
	protected $tabTitle;

	public function __construct()
	{
	}

	public static function build()
	{
		$view = new self();
		return $view;
	}

	public function tabTitle(string $tabTitle)
	{
		$this->tabTitle = $tabTitle;
		return $this;
	}

	public function html(string $html)
	{
		$this->html = $html;
		return $this;
	}

	public function get()
	{
		return [
			'title'=>$this->tabTitle,
			'html'=>$this->html,
		];

	}

}