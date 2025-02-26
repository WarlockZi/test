<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Val extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'value',
		'description',
		'type',
		'property_id',
	];

	public function property()
	{
		return $this->belongsTo(Property::class);
	}

	public function product(){
		return $this->morphedByMany(Product::class, 'valuable');
	}

}