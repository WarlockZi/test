<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'sess',
        'ip',
        'submitted',
    ];

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function orderItems(): \Illuminate\Support\Collection
    {
        $orderItems = [];
        $this->products()
            ->each(function ($product, $key) use (&$orderItems) {
                $orderItems[] = $product->orderItem;
            });
        return collect($orderItems);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'order_product',
            'order_id',
            'product_id',
            'id',
            '1s_id')
            ->withPivot('order_id', 'product_id')
            ->whereHas('orderItems');
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
