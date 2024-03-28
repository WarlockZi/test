<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
//	use SoftDeletes;
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