<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\Pivot;

class Compare extends Pivot
{
	public $timestamps = true;
    protected $table = 'compares';

	protected $fillable = [
        'sess',
		'user_id',
		'product_id',
	];

}
