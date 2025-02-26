<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'loc_storage_cart_id',
        'ip',
        'submitted',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'order_product',
            'order_id',
            'product_id',
            'id',
            '1s_id')
            ->withWhereHas('orderItems',
                fn($q)=>$q->where('count','>',0))
            ->groupBy('product_id')//            ->whereHas('orderItems')
            ;
    }

    public function productsHaveOrderItems(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'order_product',
            'order_id',
            'product_id',
            'id',
            '1s_id')
            ->whereHas('orderItems', function ($orderItem) {
                $orderItem->where('count', '>', 0);
            })

//            ->whereHas('orderItemsNotNull', function ($query) {
//                $query->where('count','>','0');
//            })
            ->groupBy('product_id')// ->whereHas('orderItems')
            ;
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            OrderItem::class,
            OrderProduct::class,
            'product_id', //in order_product
            'product_id',//in OrderItem
            'id', //in Order
            'product_id', //in order_product
        );
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function manager()
    {
        return $this->hasOne(User::class);
    }

    public static function userEmail($builder, $order, $func)
    {
        return $order->user->email;
    }
}
