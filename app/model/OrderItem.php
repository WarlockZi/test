<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

	public $table = 'orderItems';
	public $model = 'orderItem';
	public $timestamps = false;

	protected $fillable = [
		'product_id',
		'count',
		'sess',
		'ip',
		'crated_at',
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
