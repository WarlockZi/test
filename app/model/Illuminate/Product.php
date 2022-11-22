<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name', 'art', 'description',
		'category_id', 'image_id',
		'main_unit', 'base_unit'
	];

	public function mainImage()
	{
		return $this->hasOne(Image::class,
			'id',
			'main_img',
			);
	}

	public function mainUnit()
	{
		return $this->hasOne(Unit::class,
			'id',
			'main_unit',
			);
	}
	public function secondaryUnit()
	{
		return $this->hasOne(Unit::class,
			'id',
			'secondary_unit',
			);
	}

	public function detailImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->whereHas('tags', function ($q) {
			$q->where('name', 'Детальная картинка товара');
		});
	}

	public function smallPackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->whereHas('tags', function ($q) {
			$q->where('name', 'Внутритарная упаковка');
		});
	}

	public function bigPackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->whereHas('tags', function ($q) {
			$q->where('name', 'Транспортная упаковка');
		});
	}

	public function categoryCategoryRecPropsVals()
	{
		return $this->belongsTo(Category::class)->with('category_recursive.properties.vals');
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

	public function cat(){
		return $this->belongsTo(Category::class)
			->with('cat');
	}
	public function parents()
	{
		$collection = collect([]);
		$cat = $this->cat;
		while ($cat) {
			$collection->push($cat);
			$cat = $cat->cat;
		}
		return $collection;
	}


}




