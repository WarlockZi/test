<?php

namespace app\model;


use app\Domain\Product\Image\ProductMainImage;
use app\Services\ShortlinkService;
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
		'print_name',
		'short_link',
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
	protected $casts = [
		'art' => 'string',
	];

	protected function castAttribute($key, $value)
	{
		if ($this->getCastType($key) == 'string' && is_null($value)) {
			return '';
		}

		return parent::castAttribute($key, $value);
	}

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
			$product->slug = Slug::slug($product->print_name);
			return $product;
		});
	}

	public function save(array $options = [])
	{
		if (!$this->short_link)
			$this->short_link = ShortlinkService::getValidShortLink();
		parent::save($options);
	}

	public function priceWithCurrencyUnit()
	{
		$price = $this->getRelation('price');
		if ($price) {
			$number = number_format($price->price, 2, '.', ' ');
			$priceWithCurrency = "{$number} {$price->currency}";
			if ($this->promotions->count()) {
				return $this->priceWithCurrncyUnitPromotion($number, $price->currency, $number);
			}
			return "{$priceWithCurrency} / {$this->baseUnit->name}";
		}
		return 'цена - не определена';
	}

	protected function priceWithCurrncyUnitPromotion(float $number, string $currency, string $oldPrice)
	{
		$promos = $this->promotions;
		$str = '';
		foreach ($promos as $promo) {
			$newPrice = "{$promo->new_price} ";
			$str .= "{$newPrice} <span class='old-price'>{$oldPrice}</span> {$currency} / {$this->baseUnit->name}";
		}
		return $str;
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




