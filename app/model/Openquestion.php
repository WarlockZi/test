<?php

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Openquestion extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'question',
		'opentest_id',
		'pic',
		'sort'
	];

	public function opentest(){
		return $this->belongsTo(Opentest::class);
	}
	public function answers(){
		return $this->hasMany(Openanswer::class);
	}

//	public static function sort($q_ids){
//		$model = new static();
//		foreach ( $q_ids as $sort =>$id) {
//			$question = $model->findOneWhere('id',$id);
//			$question['sort']=$sort+1;
//			$model->update($question);
//		}
//	}
//
//	public function answers(){
//		return $this->hasMany(Openanswer::class);
//	}
}