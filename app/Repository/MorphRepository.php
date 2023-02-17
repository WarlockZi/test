<?php


namespace app\Repository;


class MorphRepository
{
	private static function getModelName(string $name)
	{
		return 'app\\model\\' . ucfirst($name);
	}

	public static function attach(array $req): bool
	{
		$morph = $req['morph'];
		$morphed = $req['morphed'];
		$model = self::getModelName($morph['model'])::find($morph['id']);
		$func = $req['morphed']['function'];
		$slug = $morphed['slug'];
		if ($morphed['detach'] === 'true') {
			$res = $model->$func()
				->wherePivot('slug', $slug)
				->sync([$morphed['id'] => ['slug' => $slug]]);
			return true;
		} else {
			$res = $model->$func()
				->wherePivot('slug', $slug)
				->syncWithoutDetaching([$morphed['id'] => ['slug' => $slug]]);
			return true;
		}
	}

	public static function detach($model, $function, $slug, $id)
	{
		$res = $model
			->$function()
			->withPivot([$model['id']=>['slug'=>$slug]])
			->detach($id);
		return $res;
	}
//
//	public static function attachOne(Model $morph, array $morphed, string $slug, bool $detach)
//	{
//		$modelName = self::getModelName($morphed['type']);
//		$model = $modelName::find($morphed['id']);
//
//		$function = $slug . ucfirst($morph->getTable());
//
//		if ($detach) {
//			return $model->$function()
//				->wherePivot('slug', $slug)
//				->sync([$morph->id => ['slug' => $slug]]);
//		} else {
//			return $model->$function()->syncWithoutDetach([$morph[0]->id => ['slug' => $slug]]);
//		}
//	}
//
//	public static function attachOneNoDetach(array $morph, array $morphed, string $slug, bool $detach)
//	{
//		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
//		$model = $modelName::find($morphed['id']);
//
//		$function = $slug . ucfirst($morph[0]->getTable());
//
//		if ($detach) {
//			return $model->$function()
//				->wherePivot('slug', $slug)
//				->sync([$morph[0]->id => ['slug' => $slug]]);
//		} else {
//			return $model->$function()->syncWithoutDetach([$morph[0]->id => ['slug' => $slug]]);
//		}
//	}
//
//	public static function attachMany(array $morphs, array $morphed, string $slug, bool $detach)
//	{
//		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
//		$model = $modelName::find($morphed['id']);
//
//		$function = $slug . ucfirst($morphs[0]->getTable());
//
//		if ($detach) {
//			return $attached = self::attachManyDetaching($model, $morphs, $function, $slug);
//		} else {
//			return $attached = self::attachManyNoDetaching($model, $morphs, $function, $slug);
//		}
//
//	}
//
//	protected static function attachManyNoDetaching($model, $morphs, $function, $slug)
//	{
//		$attached = [];
//		foreach ($morphs as $item) {
//			$res = $model->$function()->get()->contains($item);
//			if (!$res) {
//				$res = $model->$function()->attach([$item->id => ['slug' => $slug]]);
//				$attached[] = ImageRepository::getSrcMorph($item);
//			}
//		}
//		return $attached;
//	}


}