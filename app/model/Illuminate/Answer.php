<?php

namespace app\model\Illuminate;


class Answer extends \Illuminate\Database\Eloquent\Model
{
	public $table = 'answer';
	public  $model = 'answer';

	public $fillable = [
		'question_id'=>null,
		'answer'=>'',
		'correct_answer'=>'0',
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