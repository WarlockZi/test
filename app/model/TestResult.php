<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{

//	public $timestamps = false;

	protected $fillable = [
		'user', 'errorCnt', 'questionCnt', 'html', 'testid', 'testname',];

	public function sort($q_ids)
	{
		foreach ($q_ids as $sort => $id) {
			$question = $this->findOneWhere('id', $id)[0];
			$question['sort'] = $sort + 1;
			$this->update($question);
		}
	}


}