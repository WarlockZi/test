<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	public $table = 'orders';
	public $model = 'order';

	public $timestamps = false;

	protected $fillable = [
		'name' => '',
		'customer_id',
		'sess',
	];

	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}

}
