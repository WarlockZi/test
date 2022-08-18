<?php


namespace app\model\Illuminate;


class IlluminateModelMorphDecorator
{
	public static function updateOrCreate($model, array $attributes)
	{
		if (isset($attributes['token'])) {
			unset($attributes['token']);
		}
		if (isset($attributes['id'])) {

			if ($attributes['id']) {
				$item = $model::where('id', $attributes['id'])
					->update($attributes);
				exit(json_encode(['popup' => 'ok']));

			} else {

				unset($attributes['id']);
				$item = $model::create($attributes)->toArray();
				if (isset($attributes['morph_type'])
					&& isset($attributes['morph_id'])) {
					$morph_type = $attributes['morph_type'];
					$morph_type = "app\\model\\Illuminate\\" . ucfirst($morph_type);
					$morph_id = $attributes['morph_id'];
					$propertable = Propertable::create([
						'property_id' => $item['id'],
						'propertable_type' => $morph_type,
						'propertable_id' => $morph_id,
					]);

					exit(json_encode([
						'popup'=>'ok',
						'id'=>$item['id']
					]));
				}
			}
		}
	}


}