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

	public static function parentUnitName($builder, $item)
	{
		$parent  = $item->parent;
		return $item->parent->first()->full_name;
	}

	public static function parentUnitMultiplier($builder, $item)
	{
		return $item->pivot->multiplier;
	}

	public function parent(){
		return $this->morphToMany(Unit::class, 'unitable');
	}

	public static function multiplier($builder, $item, $field)
	{
		return isset($item->pivot->multiplier) ? $item->pivot->multiplier : 0;
	}

	public function units()
	{
		return $this
			->morphedByMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id');
	}

	public function product()
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

