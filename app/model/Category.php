<?php

namespace app\model;

class Category extends Model
{

	public $table = 'categories';
	public $model = 'category';

	protected $fillable = [
		'name' => '',
		'description' => '',
		'category_id' => 0,
		'sort'=>1,
		'img'=>'',
	];

	public function parent()
	{
		return $this->hasOne(Category::class);
	}


	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
