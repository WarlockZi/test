<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'country_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}



}