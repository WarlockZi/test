<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProduct extends Model
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
        return $this->hasMany(OrderItem::class, 'order_id','order_id');
    }


}
