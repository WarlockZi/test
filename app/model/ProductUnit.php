<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    protected $table = 'product_unit';

    public function units():hasMany
    {
        return $this->hasMany(Unit::class, 'product_unit', 'product_1s_id');
    }
    public function unit():hasOne
{
    return $this->hasOne(Unit::class, 'id', 'unit_id');
}
    public function product():hasOne{
        return $this->hasOne(Product::class, '1s_id','product_1s_id', );

    }

}
