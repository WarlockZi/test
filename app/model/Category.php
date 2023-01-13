<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	protected $fillable = [
		'name' => '',
		'description' => '',
		'sort' => 1,
		'img' => '',
		'category_id' => 0,
	];

	public function mainImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'main');
	}

	public static function frontCategories()
	{
		return static::where('show_front', 1)
			->with('children')
			->get();
	}

	public function properties()
	{
		return $this->morphToMany(Property::class, 'propertable');
	}

	public function category()
	{
		return $this->parent()->with('parentRecursive');
	}

	public function cat()
	{
		return $this->belongsTo(Category::class);
	}
	public function parents()
	{
		return $this->cat()->with('parents');
	}

	public function parent()
	{
//		return $this->belongsTo(Category::class, 'category_id')
//			->with('properties.vals');
		return $this->belongsTo(Category::class, 'category_id');
	}
	public function parentRecursive()
	{
		return $this->parent()->with('parentRecursive');
	}


	public function products()
	{
		return $this->hasMany(Product::class);
	}


	public function childrenRecursive()
	{
		return $this->children()->with('childrenRecursive');
	}

}
