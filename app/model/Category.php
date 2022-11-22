<?php

namespace app\model;


class Category extends \app\model\Model
{

	public $table = 'categories';
	public $model = 'category';

	protected $fillable = [
		'name' => '',
		'description' => '',
		'category_id' => 0,
		'sort' => 1,
		'img' => '',
	];


}
