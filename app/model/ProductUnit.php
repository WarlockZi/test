<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUnit extends Pivot
{

	public $timestamps = false;

	protected $fillable = [
		'product_1s_id',
        'unit_id',
        'multiplier',
        'is_base',
        'is_shippable',
	];
    protected $table ='product_unit';

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'product_unit','product_1s_id');
    }
}
