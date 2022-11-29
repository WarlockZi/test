<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
	public $table = 'planning';
	public $model = 'planning';

	protected $fillable = [
		'employee'=>0,
		'plan'=>'',
		'do'=>[],
	];

//	public static function delete($id)
//	{
//		return parent::delete($id);
//
//	}

}