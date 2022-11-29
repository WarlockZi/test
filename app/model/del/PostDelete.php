<?php

namespace app\model;

class PostDelete extends Model
{

//	public  $model = 'post';
//	public  $table = 'posts';
//
//	protected $fillable = [
//		'name' => '',
//		'chief' => '',
//		'subordinate' => '',
//	];
//
////	public function __construct()
////	{
////	}
//
//	public static function cheifs($id)
//	{
//		$model = new static();
//		$cheifs = $model->morphTo('post', 'chief', $id);
//		return $cheifs;
//	}
//
//	public static function cheif($id)
//	{
//		$model = new static();
//		$cheifs = $model->belongsTo('post', 'chief', $id);
//		return $cheifs;
//	}
//
//	public static function subordinates($id)
//	{
//		$model = new static();
//		$subordinates = $model->morphTo('post', 'subordinate', $id);
//		return $subordinates;
//	}
//
//	public static function findOneWhere($field, $value)
//	{
//		$post = parent::findOneWhere($field, $value);
//		if ($post) {
//			$post['chief'] = explode(',', $post['chief']);
//			$post['subordinate'] = explode(',', $post['subordinate']);
//		}
//		return $post;
//	}

}
