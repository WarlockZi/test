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

	public function oneParent()
	{
		return $this->belongsTo(Category::class);

	}

	public function parent_rec()
	{
		return $this->parent()->with('parent_rec');
	}

	public function parent()
	{
		return $this->belongsTo(Category::class,'category_id');
	}

	public function children()
	{
		return $this->hasMany(Category::class, 'category_id');
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
