<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
	public $timestamps = true;

	protected $fillable = [
		'role_id',
        'user_id',
	];

}