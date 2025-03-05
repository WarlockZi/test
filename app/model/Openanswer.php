<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Openanswer extends Model
{
	protected $fillable = [
		'openquestion_id'=>0,
		'answer'=>'',
		'is_correct'=>'0',
		'pic'=>''
	];

	public function openquestion(){
		return $this->belongsTo(Openquestion::class);
	}


}