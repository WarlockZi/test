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

	public static function showFrontCategories()
	{
		return static ::where('show_front',1)->get(['name'])->toArray();
	}

	public function properties()
	{
		return $this->morphToMany(Property::class,'propertable');
	}

	public function category_recursive()
	{
		return $this->parent()->with('category_recursive');
	}

	public function parent()
	{
		return $this->belongsTo(Category::class,'category_id')
			->with('properties.vals');
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
