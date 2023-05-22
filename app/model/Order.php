<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

//	public $table = 'orders';
//	public $model = 'order';

	public $timestamps = false;

	protected $fillable = [
		'product_id',
		'count',
		'sess',
		'ip',
		'user_id',
		'crated_at',
	];

	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}

	public function lead()
	{
		return $this->belongsTo(Lead::class);
	}

	public function product()
	{
		return $this->hasOne(Product::class, '1s_id', 'product_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public static function userEmail($builder, $order, $func){
		return $order->user->email;
	}


}
