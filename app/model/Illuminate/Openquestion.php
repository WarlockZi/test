<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Openquestion extends Model
{
	protected $fillable = [
		'question'=>'',
		'opentest_id'=>0,
		'pic'=>'',
		'sort'=>'100'
	];

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

	public function opentest(){
		return $this->belongsTo(Opentest::class);
	}
	public function answers(){
		return $this->hasMany(Openanswer::class);
	}
}