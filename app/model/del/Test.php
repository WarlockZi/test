<?php

namespace app\model\del;


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
		$id = $this->items[0]['id'];
		return Question::findAllWhere('parent', $id);
	}
	public function getChildren($id)
	{
		$children = $this->findAllWhere('parent', $id);
		return $children;
	}






}
