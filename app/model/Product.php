<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
    'act',
		'art',
		'description',
		'category_id',
		'image_id',
		'main_unit',
		'base_unit',
		'manufacturer_id'
	];

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
		return $this->hasOne(Unit::class,
			'id',
			'main_unit',
			);
	}

	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
	}

	public function secondaryUnit()
	{
		return $this->hasOne(Unit::class,
			'id',
			'secondary_unit',
			);
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
		return $this->belongsTo(Category::class)
			->with('cat');
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
//		return $this->morphToMany(Val::class, 'valuables')->with(Property::class);
	}

}




