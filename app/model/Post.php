<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

//	public $model = 'post';

	protected $fillable = [
		'name',
		'full_name',
		'post_id',
	];

	public function chief()
	{
		return $this->hasOne(Post::class,'id','post_id');
	}


}
