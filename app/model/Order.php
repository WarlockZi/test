<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
	public $timestamps = true;

	protected $fillable = [
		'product_id',
		'count',
        'unit_id',
		'sess',
		'ip',
		'user_id',
		'bill_id',
        'created_at',
		'created_at',
        'updated_at',
        'deleted_at'
	];

	public function items():HasMany
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

    public function unit()
    {
        return $this->hasOne(Unit::class,'id','unit_id');
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
