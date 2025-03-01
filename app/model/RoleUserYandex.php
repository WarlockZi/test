<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUserYandex extends Pivot
{
	public $timestamps = true;

	protected $fillable = [
		'role_id',
        'user_yandex_id',
	];

}