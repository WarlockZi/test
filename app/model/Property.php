<?php


namespace app\model;


class Property extends Model
{

	public $table = 'properties';
	public $model = 'property';

	protected $fillable = [
		'name' => '',
		'value'=>'',
		'description'=>'',
		'type'=>'',
	];

}