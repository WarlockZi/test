<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

	public $table = 'orderItems';
	public  $model = 'orderItem';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'date',
		'customer_id',
		'sess'
	];


	public function order()
	{
		return $this->belongsTo(Order::class);

	}


}
