<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Unitable extends Model
{

	public $timestamps = false;

	protected $fillable = [
        'unit_id',
        'unitable_type',
        'multiplier',
		'product_id',
        'main'
	];
//    protected $table ='product_unit';
}
