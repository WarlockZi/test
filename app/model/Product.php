<?php

namespace app\model;


use app\service\Account\AccountService;
use app\service\AuthService\AuthService;
use app\service\Cart\CartService;
use app\service\Image\del\ProductImageService;
use app\service\Like\LikeService;
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
use stdClass;


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
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $with = ['ownProperties'];
    protected $casts = [
        'art' => 'string',
    ];
    protected $appends = [
        'mainImage',
    ];

    //////likes
    public function like(): HasOne
    {
        $account_id = AuthService::accountId();
        return $this->hasOne(Like::class, 'product_id', '1s_id')
            ->where('account_id', $account_id);
    }
    public function getIsLikedAttribute()
    {
        $account_id = AuthService::accountId();

        if ($account_id) {
            return $this->relationLoaded('likes')
                ? $this->likes->isNotEmpty()
                : Like::where('account_id', $account_id)
                    ->where('product_id', $this['1s_id'])
                    ->exists();
        }
        return isset($_SESSION['likes']) && in_array($this['1s_id'], $_SESSION['likes']);
    }
    public function scopeLikeStatus($query)
    {
        $account_id = AuthService::accountId();
        if ($account_id) {
            $query->with(['like' => function($q) use ($account_id) {
                $q->where('account_id', $account_id);
            }]);
        }
        return $query;
    }

    //// compare
    public function scopeIsCompared($query)
    {
        $account_id = AuthService::accountId();
        if ($account_id) {
            return $query->whereHas('compare', function($q) use ($account_id) {
                $q->where('account_id', $account_id)
;
            });
        }

        // Для гостей фильтруем по сессии
        $sessionCompare = session()->get('compare', []);
        $productIds = array_keys($sessionCompare);

        return $query->whereIn('id', $productIds);
    }
    public function getIsComparedAttribute()
    {
        $account_id = AuthService::accountId();

        if ($account_id) {
            if ($this->relationLoaded('compare')) {
                return $this->compare->isNotEmpty();
            }else{
                return Compare::where('account_id', $account_id)
                    ->where('product_1s_id', $this['1s_id'])
                    ->exists();
            }
        }
        return isset($_SESSION['compares']) && in_array($this['1s_id'], $_SESSION['compares']);
    }
    public function compare(): HasOne
    {
        $account_id = AuthService::accountId();
        return $this->hasOne(Compare::class, 'product_1s_id', '1s_id')
            ->where('account_id', $account_id);
    }

/// cart items
    public function cartItems(): hasMany
    {
        return $this->hasMany(OrderItem::class, 'product_1s_id', '1s_id');
    }

    public function getCartItemsAttribute(): object|array
    {
        $account_id = AuthService::accountId();
        if ($account_id) {
            if ($this->relationLoaded('cartItems')) {
                return $this->getRelation('cartItems');
            }
            return OrderItem::where('product_1s_id', $this['1s_id'])
                ->where('account_id', $account_id)
                ->get();
        }

        $sessionCart = session()->get('cart_items', []);
        $units = $sessionCart[$this['1s_id']] ?? [];

        if (empty($units)) {
            return collect([]);
        }

        $cartItems = collect($units)->map(function ($count, $unit_id) {
            return [
                'unit_id' => $unit_id,
                'product_1s_id' => $this['1s_id'],
                'count' => $count,
            ];
        });

        return $cartItems;
    }

    public function scopeInCart($query, $onlyNotOrdered, array $productSelect=null, array $orderitemSelect=null)
    {
        $account_id = AuthService::accountId();
        if ($account_id) {
            return $query
                ->select($productSelect??'*')
                ->whereHas('cartItems', function($q) use ($account_id, $onlyNotOrdered) {
                $q->where('account_id', $account_id);
                if ($onlyNotOrdered) {
                    $q->whereNull('order_id');
                }
            })->with(['cartItems'=>function($q) use ($onlyNotOrdered, $orderitemSelect) {
                $q->select($orderitemSelect??'*');
                if ($onlyNotOrdered) {
                    $q->whereNull('order_id');
                }
            }]);
        }

        // Для гостей фильтруем по сессии
        $sessionCart = session()->get('cart_items', []);
        $productIds = array_keys($sessionCart);

        return $query->whereIn('id', $productIds);
    }

    public function getMainImageAttribute(): string
    {
        return APP->get(ProductImageService::class)->getImageRelativePath($this);
    }

    public function productUnits(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'product_unit', 'product_1s_id', 'unit_id', '1s_id', 'id')
            ->withPivot('price');
    }
    public function shippableUnits(): BelongsToMany
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
            ->wherePivot('is_shippable', '1')
            ->orderByPivot('price')
            ->withPivot('id', 'price', 'is_shippable', 'divider', 'multiplier', 'is_from_1s');
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
            ->orderByPivot('price')
            ->withPivot('id', 'price', 'is_shippable', 'divider', 'multiplier', 'is_from_1s');
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(
            ImageProduct::class,
            'image_product',
            'image_id',
            'product_id',
            'id',
            'id',
        )
            ->using(ImageProduct::class)
            ->withPivot('name', 'type');
    }

    public function getBaseUnitAttribute()
    {
        $from1s       = $this->units()->wherePivot('is_from_1s', 1)->first();
        $withMinPrice = 10_000_000;
        $baseUnit     = null;
        foreach ($this->units as $unit) {
            if ($unit->pivot->price < $withMinPrice) {
                $withMinPrice = $unit->pivot->price;
                $baseUnit     = $unit;
            }
        }
        return $baseUnit ?? $from1s;
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

    public function ownProperties(): HasOne
    {
        return $this
            ->hasOne(ProductProperty::class,
                'product_1s_id',
                '1s_id');
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
        list($field, $value) = CartService::getCartFieldValue();
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

    public function scopeWithActivePromotions($query)
    {
        return $query->with(['promotions' => function ($q) {
            $q->where('active_till', '>=', Carbon::today()->toDateString())
                ->with('unit');
        }]);
    }
    public function activePromotions(): hasMany
    {
        return $this->promotions()
            ->where('active_till', '>', Carbon::today()->toDateString())
            ->with('unit');
    }
    public function inactivePromotions(): hasMany
    {
        return $this->promotions()
            ->where('active_till', '<', Carbon::today()->toDateString())
            ->with('unit');
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
        list($field, $value) = CartService::getCartFieldValue();
        $order = Order::where($field, $value)->first();
        $id    = $order?->id ?: null;
        return $this->hasOne(OrderProduct::class,
            'product_id',
            '1s_id',
        )->where('order_id', $id);
    }

    public function orders(): HasMany|BelongsToMany
    {
        $user = AuthService::getUser();
        if ($user) {
            return $this
                ->belongsToMany(Order::class)
                ->where('user_id', $user->id);
        }

        return $this
            ->hasMany(Order::class, 'vitex_guest_id', AuthService::getUser());
    }


}




