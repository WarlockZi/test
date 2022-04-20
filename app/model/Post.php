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
		$cheifs = $model->morphTo('post', 'cheif', $id);
		return $cheifs;
	}

	public static function subordinates($id)
	{
		$model = new static();
		$subordinates = $model->morphTo('post', 'subordinate', $id);
		return $subordinates;
	}

	public static function findOneWhere($field, $value)
	{
		$post = parent::findOneWhere($field, $value);
		$post['chief'] = explode(',', $post['chief']);
		$post['subordinate'] = explode(',', $post['subordinate']);
		return $post;
	}

}
