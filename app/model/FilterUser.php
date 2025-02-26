<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class FilterUser extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
        'user_id',
        'model',
	];

}