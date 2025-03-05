<?php

namespace app\model;


class Question extends \Illuminate\Database\Eloquent\Model
{
	public $timestamps = false;

	protected $fillable = [
		'qustion', 'test_id', 'picq', 'sort'];

	public static function sort($q_ids)
	{
		$model = new static();
		foreach ($q_ids as $sort => $id) {
			$question = $model->find($id);
			$question->sort = $sort + 1;
			$question->save();
		}
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}

	public function test()
	{
		return $this->belongsTo(Test::class);
	}


}