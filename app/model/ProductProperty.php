<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{

	public $timestamps = false;
	protected $fillable = [
		'name' => '',
		'property_id' => '',
		'val_id' => '',
		'product_1s_id' => '',
	];


	public function property()
	{
		return $this->hasOne(Property::class);
	}

	public function val()
	{
		return $this->hasOne(Val::class, 'propertable');
	}



}