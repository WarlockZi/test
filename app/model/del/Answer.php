<?php

namespace app\model\del;

use app\core\App;
use app\model\Model;


class Answer extends Model
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