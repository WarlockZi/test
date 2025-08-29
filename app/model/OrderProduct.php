<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Pivot
{
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'product_id',
//        'created_at',
//        'updated_at',
        'deleted_at',
    ];



    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'product_id',
            '1s_id'
        )
            ->with('orderItems');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class,
            'order_product_id',
            'id',
        );

    }
}
