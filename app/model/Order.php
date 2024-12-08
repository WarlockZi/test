<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
	public $timestamps = true;

	protected $fillable = [
		'user_id',
		'user_id',
		'product_id',
        'unit_id',
		'bill_id',
		'count',
		'sess',
		'ip',
		'submitted',
        'created_at',
		'created_at',
        'updated_at',
        'deleted_at'
	];

	public function items():HasMany
	{
		return $this->hasMany(OrderItem::class);
	}

	public function lead():BelongsTo
	{
		return $this->belongsTo(Lead::class);
	}

	public function product():HasOne
	{
		return $this->hasOne(Product::class, '1s_id', 'product_id');
	}

	public function user():BelongsTo
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
