<?php

namespace app\model;


use app\core\Auth;
use app\Services\ProductImageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
        'image_id',
        'manufacturer_id',
        'category_id',
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
    protected $appends = [
        'price',
        'mainImage',
    ];

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            OrderItem::class,
            OrderProduct::class,
            'product_id', //in order_product
            'order_product_id',//in OrderItem
            '1s_id', //in Product
            'id' //in order_product
        );
    }

    public function orderProduct()
    {
        $oI = $this->hasOne(
            OrderProduct::class,
            'product_id',
            '1s_id',
        );
        return $oI;
    }

    public function order(): HasOne|null
    {
        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)->first();

        return !empty($order)

            ? $this->hasOne(OrderProduct::class,
                'product_id',
                '1s_id',
            )->where('order_id', $order->id)

            : null;
    }

    public function orders()
    {
        $user = Auth::getUser();
        if ($user) {
            return $this
                ->belongsToMany(Order::class)
                ->where('user_id', $user->id);
        }

        return $this
            ->hasMany(Order::class, 'loc_storage_cart_id', Auth::getUser());
    }

    public function ownProperties(): HasOne
    {
        return $this
            ->hasOne(ProductProperty::class,
                'product_1s_id',
                '1s_id');
    }

    public function like(): HasOne
    {
        list($field, $value) = Auth::getCartFieldValue();
        return $this->hasOne(Like::class, 'product_id', '1s_id')
            ->where($field, $value);
    }

    public function compare(): HasOne
    {
        list($field, $value) = Auth::getCartFieldValue();
        return $this->hasOne(Compare::class, 'product_id', '1s_id')
            ->where($field, $value);
    }

    public function seo_h1()
    {
        return $this->ownProperties->seo_h1 ?? $this->name;
    }

    public function seo_article()
    {
        return $this->ownProperties->seo_article ?? $this->ownProperties->seo_description ?? 'Описание товара отстутствует';
    }

    public function seo_title()
    {
        return $this->ownProperties->seo_title ?? $this->name . " - купить в Вологде оптом выгодно - VITEX";
    }

    public function seo_description()
    {
        return $this->ownProperties->seo_description ?? $this->name . " Интернет-магазин медицинских перчаток, одноразового инструмента и расходников VITEX в Вологде. Оперативный ответ менеджера, быстрая доставка, доступные оптовые цены. Звоните и заказывайте прямо сейчас или на сайте онлайн";
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    protected function getShortLinkAttribute(): string
    {
        $link   = $this->ownProperties->short_link ?? '';
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? '';
        $host   = $_SERVER['HTTP_HOST'] ?? '';
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
        return $this->priceRelation()->first()->price ?? null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ' ');
    }

    public function priceRelation(): HasOne
    {
        return $this->hasOne(Price::class, '1s_id', '1s_id');
    }

    protected function getUnitsTableAttribute()
    {
        $arr      = [];
        $units    = $this->units;
        $baseUnit = $this->baseUnit->name;
        foreach ($units as $unit) {
            $price                        = number_format((float)$this->price, 2, '.', ' ');
            $formatted_sum                = number_format((float)$this->price * $unit->pivot->multiplier, 2, '.', ' ');
            $pivot                        = $unit->pivot;
            $sid                          = $pivot->product_1s_id;
            $arr[$sid]['price']           = (float)$this->price;
            $arr[$sid]['currency']        = '₽';
            $arr[$sid]['1s_id']           = $sid;
            $arr[$sid]['name']            = $unit->name;
            $arr[$sid]['base_unit_name']  = $baseUnit;
            $arr[$sid]['multiplier']      = $unit->pivot->multiplier;
            $arr[$sid]['formatted_price'] = $price;
            $arr[$sid]['formatted_sum']   = $formatted_sum;
        }
        return $arr;
    }

    protected function getBaseUnitPriceAttribute()
    {
        $baseUnit = $this->baseUnit;
        $price    = number_format((float)$this->price, 2, '.', ' ');
        return "{$price} ₽ / {$baseUnit?->name}";
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

    public function unsubmittedOrders(): HasMany
    {
        list($field, $value) = Auth::getCartFieldValue();
        $orders = $this
            ->hasMany(Order::class, $field, $value)
            ->where('submitted', '0');

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

    public function units(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this
            ->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('id', 'multiplier', 'is_base', 'is_shippable')->orderByPivot('multiplier');
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

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }


    public function categoryCategoryRecPropsVals()
    {
        return $this->belongsTo(Category::class)->with('parentRecursive.properties.vals');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,
            '1s_category_id',
            '1s_id',
        );
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


}




