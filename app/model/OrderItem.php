<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

	public $table = 'orderItems';
	public $model = 'orderItem';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'sess',
		'order_id',
		'product_id',
		'customer_id',
		'count',
		'date',
	];

	////////auth
	///  Надо ли проверять электронку
	/// id

//*name
//surname
//middle_name

//-/*/-mobile
// (*code)
//-/*/-phone
//company

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->hasOne(Product::class, '1s_id', 'product_id');
	}


}
