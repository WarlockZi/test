<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Compare extends Pivot
{
	public $timestamps = true;
    protected $table = 'compares';

	protected $fillable = [
        'loc_storage_cart_id',
		'user_id',
		'product_id',
	];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class,
            '1s_id',
            'product_id');
    }

}
