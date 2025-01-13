<?php

namespace app\model;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
	public $timestamps = true;
    protected $table = 'likes';

	protected $fillable = [
        'sess',
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
