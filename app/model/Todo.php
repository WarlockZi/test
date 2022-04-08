<?php

namespace app\model;

class Todo extends Model
{

	protected $table = 'todos';

	protected $fillable = [
		'name' => 'Название',
		'post_id' => null,
		'user_id' => null,
		'type' => 'день',
		'description' => 'Описание',
	];

}
