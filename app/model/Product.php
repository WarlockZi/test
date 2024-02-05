<?php

namespace app\model;


use app\Domain\Product\Image\ProductMainImage;
use app\Services\Slug;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
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
		'base_unit',
		'manufacturer_id',
		'title',
		'keywords',
		'description',
		'1s_category_id',
		'1s_id',
		'instore',
		'base_equals_main_unit',
	];

	protected $appends = ['mainImagePath'];

	protected function getMainImagePathAttribute()
	{
		$path = (new ProductMainImage($this))->getRelativePath();
		return $path ? $path : ImageView::noImageSrc();
	}

	public function properties()
	{
		return $this
			->hasOne(ProductProperty::class, 'product_1s_id', '1s_id');
	}

	public function baseUnit()
	{
		return $this
			->belongsTo(Unit::class, 'base_unit', 'id');
	}

	public function seo()
	{
		return $this
			->hasOne(Seo::class, 'product_category_1sid', '1s_id');
	}

	public function values()
	{
		return $this->morphToMany(Val::class, 'valuable');
	}

	public function promotions()
	{
		return $this->hasMany(Promotion::class, 'product_1s_id', '1s_id');
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
//			)->where('slug','main');
	}

	public function smallpackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', 'smallpack');
	}

	public function bigPackImages()
	{
		return $this->morphToMany(
			Image::class,
			'imageable',
			)->where('slug', 'bigpack');
	}

	public function categoryCategoryRecPropsVals()
	{
		return $this->belongsTo(Category::class)->with('parentRecursive.properties.vals');
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

	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
	}

}




