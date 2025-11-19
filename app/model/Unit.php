<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

   public function products(): BelongsToMany
   {
        return $this->belongsToMany(
            Product::class,
            'product_unit',
            'product_1s_id',
            'unit_id',
            'id',
            '1s_id',
        );
    }
    public function prices(): HasManyThrough
    {
        $productId = $this->products()->first()->pivot->product_1s_id;
        return $this->hasManyThrough(
            Price::class,
            ProductUnit::class, // промежуточная модель
            'unit_id', // внешний ключ в промежуточной таблице
            'product_unit_id', // внешний ключ в целевой таблице
            'id', // локальный ключ
            'id' // ключ в промежуточной таблице
        )
            ->where('product_unit.product_1s_id',$productId)
            ->with(['type','currency'])
            ;
    }
}

