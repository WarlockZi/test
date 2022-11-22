<?php

namespace app\model\illuminate;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	public $model = 'post';

	protected $fillable = [
		'name' => '',
		'chief' => '',
		'subordinate' => '',
	];


	public function chief()
	{
		return $this->hasOne(Post::class,'id','chief');
	}

	public function subordinates()
	{
		return $this->hasMany(Post::class,'chief','id');
	}

}
