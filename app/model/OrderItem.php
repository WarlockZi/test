<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    public $table = 'orderitems';
    public $timestamps = true;

    protected $fillable = [
        'order_product_id',
        'product_id',
        'unit_id',
        'product_unit_id',
        'price_id',
        'count',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function price(): belongsTo
    {
        return $this->belongsTo(Price::class);
    }

//    public function unit(): hasOneThrough
//    {
//        return $this->hasOneThrough(
//            Unit::class,
//            ProductUnit::class,
//            'id',
//            'id',
//            'product_unit_id',
//            'unit_id',
//        );
//    }
    public function unit(): belongsToMany
    {
        return $this->belongsToMany(
            Unit::class,
            'product_unit',
            'id',
            'unit_id',
            'product_unit_id',
            'id',
        )->withPivot('price')
            ;
    }

    public function order(): belongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public static function leadData($columnBuilder, $orderItem, $fieldName)
    {
        $name    = $orderItem?->lead?->name ?? 'имя';
        $company = $orderItem?->lead?->company ?? 'компания';
        $phone   = $orderItem?->lead?->phone ?? 'телефон';
        return "{$name} - {$company} - {$phone}";
    }

    public function productUnit(): HasOne
    {
        return $this->hasOne(
            ProductUnit::class,
            'id',
            'product_unit_id');
    }
}
