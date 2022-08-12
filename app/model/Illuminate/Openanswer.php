<?php

namespace app\model\Illuminate;

use Illuminate\Database\Eloquent\Model;

class Openanswer extends Model
{
	protected $fillable = [
		'openquestion_id'=>null,
		'answer'=>'',
		'is_correct'=>'0',
		'pic'=>''
	];

	public function openquestion(){
		return $this->belongsTo(Openquestion::class);
	}


}