<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
	public $timestamps = true;

	protected $fillable = [
		'order_id',
		'product_id',
	];

	public function orders():HasMany
	{
		return $this->hasMany(Order::class);
	}
    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class,
        'order_product_id',
        'id',
        );

    }
}
