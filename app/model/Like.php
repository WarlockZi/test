<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
	public $timestamps = true;
    protected $table = 'likes';

	protected $fillable = [
        'sess',
		'user_id',
		'product_id',
	];

}
