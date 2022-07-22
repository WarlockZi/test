<?php

namespace app\view;

class MyView
{
	public $table;
	protected $items;
	protected $form;
	protected $parent;

	function __construct()
	{

	}
	public function belolongsTo(string $model,$id)
	{
		$model = new $model;
		$field = $model->model.'_id';
		$this->items = $this->model::where($field,'=',$id)->get();
		return $this;
	}
	public function all()
	{
		$this->items = $this->model::findAll();
		return $this;
	}

	public function get(): string
	{
		if ($this->form === 'list') {
			$form = $this->getList();
			return $form->html;
		}

	}

	public static function list()
	{
		$view = new static();
		$view->form = 'list';
		return $view;
	}
}