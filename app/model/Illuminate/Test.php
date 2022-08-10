<?php

namespace app\model\Illuminate;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

	public $table = 'test';
	public $model = 'test';

	public $fillable = [
		'id' => 0,
		'name' => '...',
		'enable' => 0,
		'parent' => 0,
		'isTest' => 1,
	];

	public $hasMany = [];

	public function questions(){

		return $this->hasMany(Question::class);
	}

	public function parent(){

		return $this->belongsTo(Test::class, 'parent');
	}

	public function getChildren($id)
	{
		return $this->hasMany(Test::class,'parent');

	}

}
