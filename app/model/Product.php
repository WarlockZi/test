<?php

namespace app\model;


use app\service\AuthService\Auth;
use app\service\Image\del\ProductImageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'category_1s_id',
        'manufacturer_id',
        '1s_id',
        'name',
        'print_name',
        'sort',
        'art',
        'txt',
        'slug',
        'image_id',
        'instore',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'art' => 'string',
    ];
    protected $appends = [
        'mainImage',
    ];

    public function getMainImageAttribute(): string
    {
        return APP->get(ProductImageService::class)->getImageRelativePath($this);
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(
            Unit::class,
            'product_unit',
            'product_1s_id',
            'unit_id',
            '1s_id',
            'id',
        )
            ->using(ProductUnit::class)
            ->orderByPivot('multiplier')
            ->withPivot('id', 'price', 'is_shippable', 'multiplier');
    }

    public function getBaseUnitAttribute()
    {
        return $this->units()->wherePivot('multiplier', 1)->first();
    }

    public function getShippableUnitsAttribute()
    {
        return $this->units()->wherePivot('is_shippable', 1)->get();
    }

    public function scopeWithShippableUnitsPrice($query)
    {
        return $query->with(['shippableUnits' => function ($q) {
            return $q
                ->with([
                    'price1s.currency',
                    'price1s.type',
                ]);
        }]);
    }

    public function scopeWithBaseUnitPrice($query)
    {
        return $query->with([
            'baseUnit' => function ($q) {
                return $q
                    ->with([
                        'price1s.currency',
                        'price1s.type',
                    ]);
            }
        ]);
    }

    public function orderItem(): hasOneThrough
    {
        return $this->hasOneThrough(
            OrderItem::class, //дб order_product_id
            OrderProduct::class,
            'product_id',//orderitems
            'order_product_id', //order_product for orderitems
            '1s_id', //proudcts
            'id', //order_product
        );
    }

    public function orderItems(): hasManyThrough
    {
        return $this->hasManyThrough(
            OrderItem::class, //дб order_product_id
            OrderProduct::class,
            'product_id',//orderitems
            'order_product_id', //order_product for orderitems
            '1s_id', //proudcts
            'id', //in order_product
        );
    }

    public function orderProduct(): hasOne
    {
        return $this->hasOne(
            OrderProduct::class,
            'product_id',
            '1s_id',
        );
    }

    public function order()
    {
//        list($field, $value) = Auth::getCartFieldValue();
//        $order = Order::where($field, $value)
//            ->whereNull('submitted')
////            ->select('id')
////            ->withCount(['products as products_count' => function ($query) {
////                $query->where('order_product.deleted_at', NULL); // withoutTrashed() не работает
////            }])
//            ->first();
//        return $order;

        list($field, $value) = Auth::getCartFieldValue();
        $order = Order::where($field, $value)->first();

        return $this->hasOne(OrderProduct::class,
            'product_id',
            '1s_id',
        )->where('order_id', $order->id);
    }

    public function orders(): HasMany|BelongsToMany
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

    protected function getMainImagePathAttribute(): string
    {
        $pis = APP->get(ProductImageService::class);
        return $pis->getImageRelativePath($this);
    }


    ///price
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2, '.', ' ');
    }

    protected function priceWithCurrncyUnitPromotion(float $number, string $currency, string $oldPrice): string
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
        throw new \Exception('type is required');
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

    public function values(): MorphToMany
    {
        return $this->morphToMany(Val::class, 'valuable');
    }

    public function promotions(): hasMany
    {
        return $this->hasMany(Promotion::class, 'product_1s_id', '1s_id');
    }

    public function activePromotions(): hasMany
    {
        return $this->promotions()
            ->where('active_till', '>=', Carbon::today()->toDateString());
    }

    public function inactivePromotions(): hasMany
    {
        return $this->promotions()
            ->where('active_till', '<', Carbon::today()->toDateString());
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,
            'category_1s_id',
            's_id',
        );
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class)->with('category_rec');
    }

    public function parentCategoryRecursive(): BelongsTo
    {
        return $this->category()->with('parentRecursive');
    }
//    public function baseUnit(): hasOneThrough
//    {
//        return $this->hasOneThrough(
//            Unit::class,
//            ProductUnit::class,
//            'product_1s_id',// in productUnit
//            'id',//in unit
//            '1s_id',//in product
//            'unit_id'//in productUnit
//        )
//            ->where('multiplier', '1');
//    }
}




