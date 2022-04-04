<?php

namespace app\model;

class Post extends Model
{

	protected $table = 'posts';
	protected $model = 'post';

	protected $fillable = [
		'name' => '',
		'chief' => [],
		'subordinate' => [],
	];

	public static function cheifs($id)
	{
		$model = new static();
		$cheifs = $model->morphTo('post','cheif',$id);
		return $cheifs;
	}

	public static function subordinates($id)
	{
		$model = new static();
		$subordinates = $model->morphTo('post','subordinate',$id);
		return $subordinates;
	}

}
