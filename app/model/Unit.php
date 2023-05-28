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

	public function units()
	{
		return $this
			->morphedByMany(Unit::class, 'unitable')
//			->wherePivot('multiplied_product_id')
//			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			;
	}
	public function unitUnits()
	{
		return $this
			->morphedByMany(Unit::class, 'unitable')
			->wherePivot('multiplied_product_id')
			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			;
	}
//	public function units()
//	{
//		return $this
//			->morphTo(Unit::class, 'unitable')
//			->withPivot('multiplier', 'multiplied_unit_id');
//	}
//	public function units()
//	{
//		return $this
//			->morphToMany(Unit::class, 'unitable')
//			->withPivot('multiplier', 'multiplied_unit_id');
//	}

	public static function multiplier($builder, $item, $field)
	{
		return $item->pivot->multipier ?? 0;
	}

	public function products()
	{
		return $this->belongsTo(Product::class,
			'base_unit');
	}

	public static function forSelect()
	{
		return self::select(['name', 'id'])
			->get();
	}

}

