<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'new_price',
		'count',
		'active_till',
		'product_1s_id',
		'unit_id',
	];

	public function product()
	{
		return $this
			->belongsTo(Product::class,
				'product_1s_id',
				'1s_id',
				);
	}

	public function unit()
	{
		return $this->hasOne(Unit::class,'id','unit_id');
	}

	public static function productLink($b, $i, $col)
	{
		if ($i->product)
			return $i->product->name;
	}


}