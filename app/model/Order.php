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

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products',
            'order_id', 'product_id',
            'id', '1s_id')
            ->withPivot('order_id', 'product_id');
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
//	public function orderItems():HasMany
//	{
//		return $this->hasMany(OrderItem::class);
//	}
//	public function product():HasOne
//	{
//		return $this->hasOne(Product::class, '1s_id', 'product_id');
//	}

//	public function lead():BelongsTo
//	{
//		return $this->belongsTo(Lead::class);
//	}
//    public function orderItems():belongsToMany
//    {
//        return $this->belongsToMany(OrderItem::class)
//            ->withPivot('order_id','product_id')
//            ->with('')
//            ;
//    }
}
