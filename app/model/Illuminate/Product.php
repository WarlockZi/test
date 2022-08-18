<?php

namespace app\model\Illuminate;


class Product extends \Illuminate\Database\Eloquent\Model
{
	public $timestamps = false;
	protected $fillable = [
		'name' => '',
		'description' => '',
		'category_id'=> 0,
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function properties()
	{
		return $this->morphToMany(Property::class, 'propertable');
	}

	public function categories(){
		return $this->belongsTo(Category::class)->with('category_rec');
	}


}




