<?php

namespace app\model;


class TestResult extends Model
{
	public $table = 'testResults';
	public $model = 'testResult';

	protected $fillable = [
		'html'=>'',
		'user'=>null,
//		'date'=>'',
		'errorCnt'=>null,
		'questionCnt'=>null,
		'testid'=>'',
		'testname'=>'',
	];

	public function sort($q_ids){
		foreach ( $q_ids as $sort =>$id) {
			$question = $this->findOneWhere('id',$id)[0];
			$question['sort']=$sort+1;
			$this->update($question);
		}
	}

}