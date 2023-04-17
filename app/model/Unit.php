<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
	protected $fillable = [
		'name',
		'full_name',
		'code',
		'national',
		'international'
	];

	public $timestamps = false;

	public function products()
	{
		return $this->belongsTo(Product::class,
			'main_unit');
	}

	public static function forSelect(){
		return self::select(['name', 'id'])
			->get();
	}


}

