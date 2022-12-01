<?php

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	public $table = 'orders';
	public  $model = 'order';

	protected $fillable = [
		'name' => '',
		'customer_id' => 1,
	];


	public static function cheifs($id)
	{
		$model = new static();
		$cheifs = $model->morphTo('post', 'chief', $id);
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
		if ($post) {
			$post['chief'] = explode(',', $post['chief']);
			$post['subordinate'] = explode(',', $post['subordinate']);
		}
		return $post;
	}

}
