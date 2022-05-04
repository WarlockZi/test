<?php

namespace app\model;


class Openquestion extends Model
{
	public $table = 'openquestions';
	public $model = 'openquestion';

	protected $fillable = [
		'qustion'=>'',
		'opentest_id'=>null,
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