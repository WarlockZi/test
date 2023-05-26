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

	public static function forSelect()
	{
		return self::select(['name', 'id'])
			->get();
	}

	public function units()
	{
		return $this
			->morphToMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'multiplied_unit_id');
	}

	public static function multiplier($builder, $item, $field)
	{
		return $item->pivot->multipier ?? 0;
	}
}

