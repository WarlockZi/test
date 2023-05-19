<?php

namespace app\model;


use app\core\FS;
use app\Services\Slug;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'sort',
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
		'1s_category_id',
		'1s_id',
		'instore'
	];

	protected $appends = ['mainImagePath'];

	public function getMainImagePathAttribute()
	{
		$art = trim($this->art);
		$path = "/pic/product/uploads/{$art}.jpg";
		if (is_readable(ROOT . FS::platformSlashes($path))) {
			return $path;
		} else {
			return ImageView::noImageSrc();
		}
	}
	protected static function booted()
	{
		static::Updating(function ($product) {
			$product->slug = Slug::slug($product->name);
			return $product;
		});
	}

	public function priceWithCurrencyUnit()
	{
		$price = $this->getRelation('price');
		if ($price) {
			$number = number_format($price->price, 2, '.', ' ');
			return "{$number} {$price->currency} / {$this->baseUnit->name}";
		}
		return 'цена - не определена';
	}

	public function toCartPrice()
	{
		$price = $this->getRelation('price');
		if ($price) {
			$number = number_format($price->price, 2, '.', ' ');
			return "{$number} {$price->currency} / {$this->baseUnit->name}";
		}
		return 'цена - не определена';
	}

	public function detailImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', '=', 'detail');
	}

	public function price()
	{
		return $this->hasOne(Price::class, '1s_id', '1s_id');
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
			);
	}

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

	public function parentCategoryRecursive()
	{
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




