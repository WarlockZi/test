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
		'morph_type' => null,
		'morph_id' => null,
	];



//	public function category()
//	{
//		return $this->belongsTo(\app\model\Illuminate\Category::class);
//	}

}