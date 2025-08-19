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
            ->select('products.*')
            ->with('orderItems')
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
        //            ->withWhereHas('orderItems',
//                fn($q) => $q->where('count', '>', 0)
//                    ->with('unit')
//    )         ->groupBy('product_id')//            ->whereHas('orderItems')
    }



    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
        )
            ->groupBy('product_id')
            ->with('productUnit');
    }
//    public function orderItems(): HasManyThrough
//    {
//        return $this->hasManyThrough(
//            OrderItem::class,
//            OrderProduct::class,
//            'order_id', //in order_product
//            'product_id',//in OrderItem
//            'id', //in OrderProduct
//            'product_id', //in order_product
//        );
//    }
    public function productsHaveOrderItems(): hasMany
    {
        return $this->hasMany(OrderProduct::class,
            'order_product',
            'order_id',
        )
            ->withWhereHas('orderItems', function ($orderItem) {
                $orderItem->where('count', '>', 0);
            })

//            ->whereHas('orderItemsNotNull', function ($query) {
//                $query->where('count','>','0');
//            })
            ->groupBy('product_id')// ->whereHas('orderItems')
            ;
    }
//    public function productsHaveOrderItems(): belongsToMany
//    {
//        return $this->belongsToMany(OrderProduct::class,
//            'order_product',
//            'order_id',
//            'product_id',
//            'id',
//            '1s_id')
//            ->whereHas('orderItems', function ($orderItem) {
//                $orderItem->where('count', '>', 0);
//            })
//
////            ->whereHas('orderItemsNotNull', function ($query) {
////                $query->where('count','>','0');
////            })
//            ->groupBy('product_id')// ->whereHas('orderItems')
//            ;
//    }

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
