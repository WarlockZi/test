<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
//	use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'price-type_id',
        'product_unit_id',
        'currency_id',
        'value',
    ];

    public function type(): belongsTo
    {
        return $this->belongsTo(
            PriceType::class,
            'price-type_id',
            'id',
        );
    }

    public function currency(): belongsTo
    {
        return $this->belongsTo(Currency::class);
    }
//    public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }


}