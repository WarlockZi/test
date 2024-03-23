<?php

namespace app\model;


use Carbon\Carbon;
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

	public function ActivePromotions()
	{
		return $this->product()->whereDay('active_till', '<', Carbon::today()->toDateString());
	}

	public function InactivePromotions()
	{
		return $this->product()->whereDay('active_till', '<', Carbon::today()->toDateString());
	}

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

	public static function getCount($b, $i, $col)
	{

			return $i->count;
	}


}