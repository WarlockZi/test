<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'surname',
		'middle_name',
		'mobile',
		'code',
		'phone',
		'company',
	];

	public function items()
	{
		return $this->hasMany(OrderItem::class);
	}

}
