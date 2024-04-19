<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{

	public $timestamps = false;

	protected $fillable = [
		'product_1s_id',
        'unit_id',
        'multiplier',
        'is_main'
	];
    protected $table ='product_unit';
}
