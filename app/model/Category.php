<?php

namespace app\model;


use Illuminate\Support\Facades\DB;

class Category extends \Illuminate\Database\Eloquent\Model
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
