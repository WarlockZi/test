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

	public function units($id)
	{
//		$id = $this->id=256;
		return $this
			->morphToMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			->wherePivot(function ($q)use($id){
				$q->where('multiplied_product_id', $id);
			})
//			->wherePivot('multiplied_product_id')
//			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			;
	}

	public function unit(){
		return $this
			->morphedByMany(Unit::class, 'unitable')
			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			->wherePivot(function ($q){
				$q->where('multiplied_product_id', $this->product()->id);
			})
//			->wherePivot('multiplied_product_id')
//			->withPivot('multiplier', 'multiplied_unit_id', 'multiplied_product_id')
			;
	}

	public function unitable(){
		return $this->morphTo()
//		return $this->morphedByMany(Unit::class,'unitable')
			;
	}

	public static function multiplier($builder, $item, $field)
	{
		return $item->pivot->multipier ?? 0;
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

