<?php


namespace app\model\del;


class Val extends Model
{

	public $table = 'vals';
	public $model = 'val';

	protected $fillable = [
		'name' => '',
		'value'=>'',
		'description'=>'',
		'type'=>'',
	];

}