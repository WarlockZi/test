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
    public function products(): belongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'order_product',
            'order_id',
            'product_id',
            'id',
            '1s_id',
        )
            ;
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
        )
            ->groupBy('product_id')
            ->with('productUnit');
    }
    public function orderProducts(): hasMany
    {
        return $this->hasMany(
            OrderProduct::class,
//            '1s_id',
//            'id'
        )
            ;
    }

    public function onlyProducts(): belongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'order_product',
            'order_id',
            'product_id',
            'id',
            '1s_id',
        )
            ->select('1s_id', )
            ->withPivot('deleted_at')
            ;
    }
    public function productUnits(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductUnit::class,
            OrderItem::class,
            'order_product_id',
            'id',
            'id',
            'product_unit_id'
        );
    }





    public function productsHaveOrderItems(): hasMany
    {
        return $this->hasMany(OrderProduct::class,
            'order_product',
            'order_id',
        )
            ->withWhereHas('orderItems', function ($orderItem) {
                $orderItem->where('count', '>', 0);
            })
            ->groupBy('product_id')// ->whereHas('orderItems')
            ;
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }


}
