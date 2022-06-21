<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Question extends Model
{
	public $table = 'question';
	public $model = 'question';

	protected $fillable = [
		'qustion'=>'',
		'parent'=>null,
		'picq'=>'',
		'sort'=>'100'
	];
	public function empty()
	{
		return $this->fillable;
	}
	public static function sort($q_ids){
		$model = new static();
		foreach ( $q_ids as $sort =>$id) {
			$question = $model->findOneWhere('id',$id);
			$question['sort']=$sort+1;
			$model->update($question);
		}
	}

}