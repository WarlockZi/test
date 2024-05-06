<?php

namespace app\model;


use app\Actions\Helpers;
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

    protected function shortLink(): Attribute
    {
        return Attribute::get(
            function () {
                $link = $this->getRawOriginal('short_link');
                return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/short/{$link}";
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

    protected function getMainImagePathAttribute()
    {
        $path = (new ProductMainImageEntity($this))->getRelativePath();
        return $path ? $path : ImageView::noImageSrc();
    }

    public function getPriceAttribute()
    {
        return $this->priceRelation->price;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ' ');
    }

    public function priceRelation()
    {
        return $this->hasOne(Price::class, '1s_id', '1s_id');
    }

    protected function getBaseUnitPriceAttribute()
    {
        $baseUnit = $this->baseUnit;
        $price    = number_format($this->price, 2, '.', ' ');
        return "{$price} ₽ / {$baseUnit->name}";
    }

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

    public function scopeTrashed($query, $type)
    {
        if ($type) {
            return $query->withTrashed();
        }
    }

    public function scopeWithMainImages($query)
    {
        return $query->whereHas('mainImages');
    }


    public function dopUnits()
    {
        return $this->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('is_shippable', 'multiplier')->wherePivotNull('is_base');
    }

    public function getBaseUnitAttribute()
    {
        return $this->baseUnitRelation->first();
    }

    public function baseUnitRelation()
    {
        return $this->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')->withPivot('is_shippable')->wherePivot('is_base', '=', '1');
    }

    public function shippableUnits()
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('multiplier', 'is_base', 'is_shippable')
            ->wherePivot('is_shippable', '=', '1');
    }

    public function units()
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('id', 'multiplier', 'is_base', 'is_shippable');
    }

    public function getCleanAttribute()
    {
//        Helpers::clean();
        return true;
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

    public function save(array $options = [])
    {
        if (!$this->short_link)
            $this->short_link = ShortlinkService::getValidShortLink();
        parent::save($options);
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




