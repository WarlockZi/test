<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
	public $timestamps = true;
    protected $table = 'likes';

	protected $fillable = [
		'user_id',
		'product_id',
	];

}
