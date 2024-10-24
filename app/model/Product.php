<?php

namespace app\model;


use app\Services\ProductImageService;
use app\Services\SlugService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Product extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'print_name',
        'sort',
        'art',
        'txt',
        'slug',
        'category_id',
        'image_id',
        'manufacturer_id',
        '1s_category_id',
        '1s_id',
        'instore',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'art' => 'string',
    ];
    protected $appends = ['price', 'mainImage','shortLink'];

    public function ownProperties()
    {
        return $this->hasOne(ProductProperty::class, 'product_1s_id', '1s_id');
    }

    public function scopeWithWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
    protected function getShortLinkAttribute(): string
    {
        $link = $this->ownProperties->short_link??'';
//        if (!$link) {
//            $link = ShortlinkService::getValidShortLink();
//            $this->short_link = $link;
//            $this->save();
//        }
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? '';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        return "{$scheme}://{$host}/short/{$link}";
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
        return (new ProductImageService())->getImageRelativePath($this);
    }

    public function getMainImageAttribute()
    {
        return (new ProductImageService())->getImageRelativePath($this);
    }

    public function getPriceAttribute()
    {
        return $this->priceRelation()->first()->price??null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ' ');
    }

    public function priceRelation():HasOne
    {
        return $this->hasOne(Price::class, '1s_id', '1s_id');
    }

    protected function getUnitsTableAttribute()
    {
        $arr = [];
        $units = $this->units;
        $baseUnit = $this->baseUnit->name;
        foreach ($units as $unit) {
            $price = number_format((float)$this->price, 2, '.', ' ');
            $formatted_sum = number_format((float)$this->price * $unit->pivot->multiplier, 2, '.', ' ');
            $pivot = $unit->pivot;
            $sid = $pivot->product_1s_id;
            $arr[$sid]['price'] = (float)$this->price;
            $arr[$sid]['currency'] = '₽';
            $arr[$sid]['1s_id'] = $sid;
            $arr[$sid]['name'] = $unit->name;
            $arr[$sid]['base_unit_name'] = $baseUnit;
            $arr[$sid]['multiplier'] = $unit->pivot->multiplier;
            $arr[$sid]['formatted_price'] = $price;
            $arr[$sid]['formatted_sum'] = $formatted_sum;
        }
        return $arr;
    }

    protected function getBaseUnitPriceAttribute()
    {
        $baseUnit = $this->baseUnit;
        $price = number_format((float)$this->price, 2, '.', ' ');
        return "{$price} ₽ / {$baseUnit->name}";
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

    public function orderItems():HasMany
    {
        $orderItems = $this
            ->hasMany(OrderItem::class, 'product_id', '1s_id')
            ->whereNull('deleted_at')
            ->where('sess', $_SESSION['phpSession'])//            ->get()
        ;
//        $oI = $orderItems->toArray();

        return $orderItems;
    }

    public function orders():HasMany
    {
        $orders = $this
            ->hasMany(Order::class, 'product_id', '1s_id')
            ->whereNull('deleted_at')
            ->where('sess', $_SESSION['phpSession'])//            ->get()
        ;
//        $oI = $orders->toArray();

        return $orders;
    }

    public function getBaseUnitAttribute()
    {
        return $this->baseUnitRelation->first();
    }

    public function baseUnitRelation()
    {
        return $this->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('is_shippable', 'base_is_shippable')
            ->wherePivot('is_base', '1');
    }

    public function shippableUnits()
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('multiplier', 'is_base', 'is_shippable', 'base_is_shippable')
            ->wherePivot('is_shippable', '=', '1');
    }

    public function units()
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('id', 'multiplier', 'is_base', 'is_shippable')->orderByPivot('multiplier');
    }


//    public function seo()
//    {
//        return $this
//            ->hasOne(Seo::class, 'product_category_1sid', '1s_id');
//    }

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
//            ->orWhereNull('active_till');
    }

    public function inactivePromotions()
    {
        return $this
            ->hasMany(Promotion::class, 'product_1s_id', '1s_id')
            ->where('active_till', '<', Carbon::today()->toDateString());
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
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
//   public function mainImage()
//   {
//       $art = $this->art;
//       $file = ROOT. '/pic/product/upload/'.$art.'.jpg';
//       return file_exists($file);
//   }


//    public function dopUnits()
//    {
//        return $this->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
//            ->withPivot('is_shippable', 'multiplier')->wherePivotNull('is_base');
//    }

//    protected function shortLink(): Attribute
//    {
//        return Attribute::get(
//            function () {
//                $link = $this->getRawOriginal('short_link');
//                $scheme = $_SERVER['REQUEST_SCHEME'] ?? '';
//                $host = $_SERVER['HTTP_HOST'] ?? '';
//                return "{$scheme}://{$host}/short/{$link}";
//            }
//        );
//    }
    protected static function booted()
    {
//        static::Updating(function ($product) {
//            $product->slug = Slug::slug($product->print_name);
//            return $product;
//        });
    }

//    public function save(array $options = [])
//    {
//        if (!$this->short_link)
//            $this->short_link = ShortlinkService::getValidShortLink();
//        parent::save($options);
//    }
}




