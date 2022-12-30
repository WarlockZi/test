<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',

	];

}