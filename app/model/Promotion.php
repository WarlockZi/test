<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'new_price',
		'count',
		'date',
		'product_1s_id',
	];

	public function product()
	{
		return $this
			->belongsTo(Product::class,
				'product_1s_id',
				'1s_id',
				);
	}


}