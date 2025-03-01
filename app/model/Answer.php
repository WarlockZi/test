<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'question_id','answer','correct_answer','pica','sort'
	];

}