<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'is_from_1s',
    ];
    protected $table = 'product_unit';

    public $incrementing = true;
//    public function prices(): HasMany
//    {
//        return $this->hasMany(Price::class,'id','product_unit_id', );
//    }
    public function prices()
    {
        return $this->hasMany(Price::class, 'product_unit_id');
    }
    public function price1s(): hasOne
    {
        return $this->hasOne(Price::class)
            ->whereHas('type', function ($q) {
                return $q->where('type', '1s');
            });
    }



}
