<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
	public $table = 'testResults';
	public $model = 'testResult';

	protected $fillable = [
		'user'=>0,
//		'date'=>'',
		'errorCnt'=>0,
		'questionCnt'=>0,
		'html'=>'',
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