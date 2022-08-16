<?php


namespace app\model;


class IlluminateModelDecorator extends \Illuminate\Database\Eloquent\Model
{


	public static function updateOrCreate($model, array $attributes)
	{
		if (isset($attributes['token'])) {
			unset($attributes['token']);
		}
		if (isset($attributes['id'])) {
			if ($attributes['id']) {
				$item = $model::where('id',$attributes['id'])
					->update($attributes);
				exit(['poppup'=>'ok']);
			} else {
				unset($attributes['id']);
				$item = $model::create($attributes)->toArray();
			}
		}
		exit($item['id']);
	}


}