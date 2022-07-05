<?php

namespace app\model;

class Todo extends Model
{

	public  $table = 'todos';
	public  $model = 'todo';

	protected $fillable = [
		'name' => '',
		'post_id' => null,
		'user_id' => null,
		'type' => 'день',
		'description' => '',
	];

}
