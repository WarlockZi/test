<?php

namespace app\view;


abstract class MyView
{
	public $table;
	protected $items;
	protected $form;
	protected $parent;


	public function belolongsTo(string $model, $id)
	{
		$model = new $model;
		$field = $model->model . '_id';
		$this->items = $this->items::where($field, '=', $id)->get();
		return $this;
	}

}