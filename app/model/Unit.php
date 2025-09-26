<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'full_name',
        'code',
        'international',
    ];

    public $timestamps = false;
//    public function prices(): HasMany
//    {
//        return $this->hasMany(Price::class, 'product_unit_id');
//    }
//    public function prices(): hasManyThrough
//    {
//        return $this->hasManyThrough(
//            Price::class,
//            ProductUnit::class,
//            'unit_id',
//            'product_unit_id',
//            'id',
//            'id',
//        );
//    }
//    public function prices(): belongsToMany
//    {
//        return $this->belongsToMany(
//            Price::class,
//            'product_unit',
//            'unit_id', // Внешний ключ в product_unit
//            'id', // Локальный ключ в units
//            'id', // Локальный ключ в product_unit
//            'product_unit_id', // Внешний ключ в prices
//        )
//            ->using(ProductUnit::class)
//            ->withPivot('id')
//            ;
//    }
    public function price1s(): belongsToMany
    {
        return $this->belongsToMany(
            Price::class,
            'product_unit',

            'unit_id',
            'id',
            'id',
            'product_unit_id',
        )
            ->using(ProductUnit::class)
            ;
    }
}

