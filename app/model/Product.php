<?php

namespace app\model;


class Product extends \app\model\Model
{

	public $table = 'products';
	public $model = 'product';

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function properties()
	{
		return $this->morphToMany(\app\model\Illuminate\Property::class);
	}


}




