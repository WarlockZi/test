<?php

namespace app\model\Illuminate;


class Category extends \Illuminate\Database\Eloquent\Model
{

	protected $fillable = [
		'name' => '',
		'description' => '',
		'sort' => 1,
		'img' => '',
		'category_id' => 0,
	];



	public function properties()
	{
		return $this->morphToMany(Property::class,'propertable');
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
