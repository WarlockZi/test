<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    public $table = 'orderitems';
    public $timestamps = true;

    protected $fillable = [
        'product_1s_id',
        'unit_id',
        'account_id',
        'count',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function unit()
    {
        return $this->hasOneThrough(
            Unit::class,
            ProductUnit::class,
            'product_1s_id',
            'id',
            'product_1s_id',
            'unit_id',
        )
            ->select(['units.*', 'product_unit.price as unit_price'])//->addSelect(['units.name as unit_name'])
            ;
    }
    public function order_unit()
{
    return $this->belongsTo(Unit::class, 'unit_id', 'id');
}
    public function unit_price()
    {
        return $this->hasOneThrough(
            Unit::class,
            ProductUnit::class,
            'product_1s_id',
            'id',
            'product_1s_id',
            'unit_id',
        )
            ->addSelect(['product_unit.price as unit_price'])//->addSelect(['units.name as unit_name'])
            ;
    }
    public function scopeWithUnitDetails($query)
    {
        return $query->with(['productUnit.unit'])->with('productUnit.product');
    }

    public function price(): belongsTo
    {
        return $this->belongsTo(Price::class);
    }

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product_1s_id', '1s_id');
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
}
