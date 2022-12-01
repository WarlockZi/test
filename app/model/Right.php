<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Right extends Model
{

	protected $fillable = [
		'name' => '',
		'description' => '',
	];

	public function user()
	{
		return $this->hasMany(User::class);
	}


}
