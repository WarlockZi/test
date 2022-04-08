<?php

namespace app\model;

class Todo extends Model
{

	protected $table = 'todos';

	protected $fillable = [
		'name' => 'Задача',
		'post_id' => null,
		'user_id' => null,
		'type' => 'daily',
		'description' => 'Текст...',
	];

}
