<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'country_id'
	];

}