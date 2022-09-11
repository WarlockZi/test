<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'question_id','answer','correct_answer','pica','sort'];

//	public static function delete($id)
//	{
//		return parent::delete($id);
//	}
//	public static function create($value=[],$register=false)
//	{
//		return parent::create($value);
//	}

}