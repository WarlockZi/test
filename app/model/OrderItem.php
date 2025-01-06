<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    public $table = 'orderitems';
    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'order_id',
        'unit_id',
        'count',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function order():BelongsTo
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
        return  "{$name} - {$company} - {$phone}";
	}

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class, '1s_id', 'product_id');
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Unit::class, 'id','unit_id');
    }
}
