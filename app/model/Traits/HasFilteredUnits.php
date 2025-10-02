<?php

namespace app\model\Traits;

use app\model\ProductUnit;
use app\model\Unit;

trait HasFilteredUnits
{
    public function units()
    {
        return $this->belongsToMany(
            Unit::class,
            'product_unit',
            'product_1s_id',
            'unit_id',
            '1s_id',
            'id',
        )
            ->using(ProductUnit::class)
            ->orderByPivot('multiplier')
            ->withPivot('id','price','is_shippable','multiplier')
 ;
    }
}