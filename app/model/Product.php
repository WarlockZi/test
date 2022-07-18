<?php

namespace app\model;



class Product extends \Illuminate\Database\Eloquent\Model
{

	public $table = 'products';
	public $model = 'product';

	public function category()
	{
		return $this->belongsTo(Category::class);
}


}




