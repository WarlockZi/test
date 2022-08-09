<?php

namespace app\model\Illuminate;


class Product extends \Illuminate\Database\Eloquent\Model
{

	public $table = 'products';
	public $model = 'product';

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function properties()
	{
		return $this->morphToMany(Property::class, 'propertable');
	}


}




