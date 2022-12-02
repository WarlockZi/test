<?php

namespace app\model\del;


class Openanswer extends Model
{
	public $table = 'openanswers';
	public  $model = 'openanswer';

	protected $fillable = [
		'openquestion_id'=>0,
		'answer'=>'',
		'is_correct'=>'0',
		'pic'=>''
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