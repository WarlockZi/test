<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
	use SoftDeletes;
	public $table = 'orderItems';
//	public $model = 'orderItem';
	public $timestamps = true;

	protected $fillable = [
		'product_id',
		'count',
		'sess',
		'ip',
		'crated_at',
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public static function leadData($columnBuilder, $orderItem, $fieldName)
	{
		return $orderItem->lead->name . ' - ' . $orderItem->lead->company. ' - ' . $orderItem->lead->phone;
	}

	public function product()
	{
		return $this->hasOne(Product::class, '1s_id', 'product_id');
	}

	public function lead()
	{
		return $this->hasOne(Lead::class, 'sess', 'sess');
	}


}
