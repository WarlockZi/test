<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function unit():belongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function product():belongsTo
    {
        return $this->belongsTo(Product::class, 'product_1s_id', '1s_id');
    }

}
