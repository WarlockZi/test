<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'1s_id',
		'1s_art',
		'unit',
		'unit_code',
		'currency',
		'price',
		'1s_type_code',
	];


	public function product()
	{
		return $this->belongsTo(Product::class);
	}


}