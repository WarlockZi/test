<?php

namespace app\model\Illuminate;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{

	public  $timestamps = false;

	protected $fillable = [
		'name', 'post_id', 'user_id',
		'type','description' ,
	];

}
