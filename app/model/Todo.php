<?php

namespace app\model;

class Todo extends Model {

   protected $table = 'todos';

   protected $fillable = [
   	'name' => '',
   	'post_id' => '',
	];

}
