<?php


namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

	public $table = 'properties';
	public $model = 'property';

	protected $fillable = [
		'name' => '',
		'value'=>'',
		'description'=>'',
		'category_id' => '',
		'propertable_type' => '',
		'propertable_id' => '',
	];

	public function category(){
		return $this->belongsTo(\app\model\Illuminate\Category::class);
	}

}