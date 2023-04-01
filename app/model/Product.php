<?php

namespace app\model;


use app\Services\Slug;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'xml',
    '1s_category_id',
    'act',
		'art',
		'txt',
		'slug',
		'category_id',
		'image_id',
		'main_unit',
		'base_unit',
		'manufacturer_id',
		'title',
		'keywords',
		'description',
	];

	protected static function booted() {
		static::Updating (function($product) {
			$product->slug = Slug::slug($product->name);
			return $product;
		});
	}
	public function detailImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'detail');
	}

	public function mainImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'main');

//		return $this->morphToMany(
//			Image::class,
//			'imageable',
//			)->where('slug', '=', 'main');
	}

	public function smallpackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'smallpack');
	}


	public function bigPackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'bigpack');
	}

	public function mainUnit()
	{
		return $this->belongsTo(Unit::class,
			'main_unit'
			);
	}

	public function baseUnit()
	{
		return $this->belongsTo(Unit::class,
			'base_unit',
//			'id',
			);
	}
//	public function baseUnit()
//	{
//		return $this->hasOne(Unit::class,
//			'id',
//			'base_unit',
//			);
//	}
	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
	}



	public function categoryCategoryRecPropsVals()
	{
		return $this->belongsTo(Category::class)->with('parentRecursive.properties.vals');
	}

	public function properties()
	{
		return $this->morphToMany(Property::class, 'propertable');
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function categories()
	{
		return $this->belongsTo(Category::class)->with('category_rec');
	}

	public function parentCategoryRecursive(){
		return $this->category()->with('parentRecursive');
	}

	public function values()
	{
		return $this->morphToMany(Val::class, 'valuable');
	}
//	public function valuesWithProperty()
//	{
//		return $this->morphToMany(Val::class, 'valuable')->with('property');
//	}
}




