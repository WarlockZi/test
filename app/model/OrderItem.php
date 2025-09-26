<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
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
        'price_id',
        'count',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

//    public function price(): hasOne
//    {
//        return $this->hasOne(
//            Price::class,
//            'id',
//            'price_id',
//        );
//    }
    public function price(): belongsTo
    {
        return $this->belongsTo(Price::class);
    }

    public function scopeWithPrice($q)
    {
        return $q->with(['price'=>function ($q) {
            return $q->withPriceTypeAndCurrency();
        }]);
    }

    public function unit(): hasOneThrough
    {
        return $this->hasOneThrough(
            Unit::class,
            ProductUnit::class,
            'unit_id',
            'id',
            'product_unit_id',
            'id',
        );
    }

    public function order(): BelongsTo
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
