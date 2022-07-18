<?php

namespace app\model;


class MyCategory extends Model
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


//	public function products()
//	{
//		return $this->hasMany(Product::class);
//	}

	public static function __callStatic($name, $args)
	{
		$class = 'app\model\\'.ucfirst($name);

		return $args[0]->hasMany[$class]['items'];

	}
}
