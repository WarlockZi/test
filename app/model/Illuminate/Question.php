<?php

namespace app\model\Illuminate;


class Question extends \Illuminate\Database\Eloquent\Model
{
	public $table = 'question';
	public $model = 'question';

	public $fillable = [
		'qustion'=>'',
		'parent'=>null,
		'picq'=>'',
		'sort'=>'100'
	];

	public static function sort($q_ids){
		$model = new static();
		foreach ( $q_ids as $sort =>$id) {
			$question = $model->findOneWhere('id',$id);
			$question['sort']=$sort+1;
			$model->update($question);
		}
	}

}