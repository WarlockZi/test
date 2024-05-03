<?php

namespace app\model;


use app\Domain\Product\Image\ProductMainImageEntity;
use app\Services\ShortlinkService;
use app\Services\Slug;
use app\view\Image\ImageView;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static truncate()
 */
class Product extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public $timestamps = false;
    protected $appends = ['mainImagePath'];

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
        'deleted_at',
    ];
    protected $casts = [
        'art' => 'string',
    ];

    protected function priceWithUnit(): Attribute
    {
        return Attribute::get(
            function () {
                $array = [];
                $price = $this->getRelation('price')->price;
                if ($this->baseUnit) {
                    $array['baseUnit']['price'] = number_format($price, 2, '.', ' ');
                    $array['baseUnit']['unit']  = $this->baseUnit->name;
                }
                if ($this->dopUnits) {
                    foreach ($this->dopUnits as $unit) {
                        $multiplier                              = $unit->pivot->multiplier;
                        $array['dopUnits'][$multiplier]['price'] = number_format($price * $multiplier, 2, '.', ' ');
                        $array['dopUnits'][$multiplier]['unit']  = $unit->name;
                    }
                }
                return $array;
            }
        );
    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }

        return parent::castAttribute($key, $value);
    }

    public function scopeTrashed($query, $type)
    {
        if ($type) {
            return $query->withTrashed();
        }
    }

    public function scopeWithMainImages($query)
    {
        return $query->whereHas('mainImages');
//		return $query->with('mainImages',function ($query){
//			$query->count()>0;
//		});
    }

    protected function getMainImagePathAttribute()
    {
        $path = (new ProductMainImageEntity($this))->getRelativePath();
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

    public function dopUnits()
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id')
            ->withPivot('multiplier', 'is_base');
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
        return $this
            ->hasMany(Promotion::class, 'product_1s_id', '1s_id');
    }

    public function activePromotions()
    {
        return $this
            ->hasMany(Promotion::class, 'product_1s_id', '1s_id')
            ->where('active_till', '>=', Carbon::today()->toDateString());
    }

    public function inactivePromotions()
    {
        return $this
            ->hasMany(Promotion::class, 'product_1s_id', '1s_id')
            ->where('active_till', '<', Carbon::today()->toDateString());
    }

    protected static function booted()
    {
        static::Updating(function ($product) {
            $product->slug = Slug::slug($product->print_name);
            return $product;
        });
    }

    public function getShortLink()
    {
        $protocol = $_SERVER['REQUEST_SCHEME'];
        $host     = $_SERVER['HTTP_HOST'];
        return "{$protocol}://{$host}/short/{$this->short_link}";
    }

    public function save(array $options = [])
    {
        if (!$this->short_link)
            $this->short_link = ShortlinkService::getValidShortLink();
        parent::save($options);
    }

//	public function priceWithCurrencyUnit()
//	{
//		$price = $this->getRelation('price');
//		if ($price) {
//			$number = number_format($price->price, 2, '.', ' ');
//			$priceWithCurrency = "{$number} {$price->currency}";
//			if ($this->activePromotions->count()) {
//				return $this->priceWithCurrncyUnitPromotion($number, $price->currency, $number);
//			}
//			return "{$priceWithCurrency} / {$this->baseUnit->name}";
//		}
//		return 'цена - не определена';
//	}

    protected function priceWithCurrncyUnitPromotion(float $number, string $currency, string $oldPrice)
    {
        $promos = $this->promotions;
        $str    = '';
        foreach ($promos as $promo) {
            $newPrice = "{$promo->new_price} ";
            $str      .= "{$newPrice} <span class='old-price'>{$oldPrice}</span> {$currency} / {$this->baseUnit->name}";
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




