<?php


namespace app\model;


class Property extends Model
{

	public $table = 'properties';
	public $model = 'property';

	protected $fillable = [
		'name' => '',
		'value' => '',
		'description' => '',
		'category_id'=>null,
		'propertable_type' => null,
		'propertable_id' => null,
	];

//	public function category()
//	{
//		return $this->belongsTo(\app\model\Illuminate\Category::class);
//	}

}