<?php

namespace app\model;

use app\core\App;
use app\model\Model;


class Question extends Model
{
	public $table = 'question';

	protected $fillable = [
		'qustion'=>'',
		'parent'=>null,
		'picq'=>'',
		'sort'=>'100'
	];

	public function sort($q_ids){
		foreach ( $q_ids as $sort =>$id) {
			$question = $this->findWhere('id',$id)[0];
			$question['sort']=$sort+1;
			$this->update($question);
		}
	}

}