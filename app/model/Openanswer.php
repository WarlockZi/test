<?php

namespace app\model;


class Openanswer extends Model
{
	public $table = 'openanswers';
	public  $model = 'openanswer';

	protected $fillable = [
		'openquestion_id'=>null,
		'answer'=>'',
		'is_correct'=>'0',
		'pica'=>''
	];


	public static function delete($id)
	{
		return parent::delete($id);

	}
	public static function create($value=[],$register=false)
	{
		return parent::create($value);
	}

}