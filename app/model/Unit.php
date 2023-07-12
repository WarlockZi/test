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

	public function getUnitablesCountAttribute()
	{
		return $this->units_count;
	}

	public static function parentUnitName($builder, $item)
	{
		return $item->parent->first()->full_name;
	}

	public function units()
	{
		return $this
			->morphedByMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'product_id', 'main')
			;
	}

	public function unit()
	{
		return $this
			->morphTo('unitable', Unit::class , )
			->withPivot('multiplier', 'product_id', 'main');
	}
	public function mainUnits()
	{
		return $this
			->morphedByMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'product_id', 'main')
			;
	}


	public static function parentUnitMultiplier($builder, $item)
	{
		return $item->pivot->multiplier;
	}

	public function parent()
	{
		return $this->morphToMany(Unit::class, 'unitable');
	}

	public static function multiplier($builder, $item, $field)
	{
		return isset($item->pivot->multiplier) ? $item->pivot->multiplier : 0;
	}

	public function product()
	{
		return $this->belongsTo(Product::class,
			'base_unit');
	}

}

