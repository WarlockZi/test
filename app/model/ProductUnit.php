<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUnit extends Pivot
{
    public $timestamps = false;
    protected $fillable = [
        'product_1s_id',
        'unit_id',
        'divider',
        'multiplier',
        'is_shippable',
        'price',
        'is_from_1s',
    ];

    public $incrementing = true;

    public function unit():hasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');

    }


}
