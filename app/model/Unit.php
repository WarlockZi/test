<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'full_name',
        'code',
        'national',
        'international',
        'dop_unit_id'
    ];

    public $timestamps = false;

	public function product()
	{
		return $this->belongsTo(Product::class,
			'base_unit');
	}

}

