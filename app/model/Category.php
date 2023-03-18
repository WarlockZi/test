<?php

namespace app\model;


use app\Services\Slug;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'description',
		'sort',
		'slug',
		'img',
		'category_id',
		'show_front',
		'deleted_at',
	];

	protected static function booted() {
		static::Updating (function($category) {
			$category->slug = Slug::slug($category->name);
			return $category;
		});
	}

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
			->with('childrenNotDeleted')
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


	public function products()
	{
		return $this->hasMany(Product::class);
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
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function parentRecursive()
	{
		return $this->parent()->with('parentRecursive');
	}





	public function childrenRecursive()
	{
		return $this->childrenNotDeleted()->with('childrenRecursive');
	}

	public function childrenNotDeleted()
	{
		return $this
			->hasMany(Category::class, 'category_id')
			->whereNull('deleted_at');
	}
	public function childrenDeleted()
	{
		return $this
			->hasMany(Category::class, 'category_id')
			->whereNotNull('deleted_at');
	}

}
