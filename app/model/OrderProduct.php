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
        'deleted_at',
    ];

    public function products(): hasMany
    {
        return $this->hasMany(
            Product::class,
            '1s_id',
            'product_id',
        )
            ;
    }
    public function orders(): hasMany
    {
        return $this->hasMany(Order::class);
    }
    public function orderItems(): hasMany
    {
        return $this->hasMany(OrderItem::class,
            'order_product_id',
            'id',
        );
    }
}
