<?php


namespace app\Repository;


class ListMorphRepository
{
//
//	public static function attachOneNoDetach(array $morph, array $morphed=[], string $slug='')
//	{
//		$modelName = 'app\\model\\' . ucfirst($morphed['morph']);
//		$modeld = $modelName::first();
//		$function = lcfirst($modeld->getTable());
//
//		$modelName = 'app\\model\\' . ucfirst($morph['morph_type']);
//		$model = $modelName::with($function)->find($morph['morph_id']);
//
//
//		return $model->properties()->syncWithoutDetaching($morphed['morphId']);
////		return $model->$function()->syncWithoutDetach($morphed['morphId']);
//	}
//
//	public static function attachOneDetach(array $morph, array $morphed=[], string $slug = '')
//	{
//		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
//		$model = $modelName::find($morphed['id']);
//		if ($slug) {
//			$function = $slug . ucfirst($morph[0]->getTable());
//			return $model->$function()
//				->wherePivot('slug', $slug)
//				->sync([$morph[0]->id => ['slug' => $slug]]);
//		}
//		$function = ucfirst($morph[0]->getTable());
//		return $model->$function()
//			->wherePivot('slug', $slug)
//			->sync([$morph[0]->id => ['slug' => $slug]]);
//
//
//	}
//
//	public static function attachManyDetach(array $morphs, array $morphed, string $slug)
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
//
//	protected static function attachManyDetaching($model, $morphs, $function, $slug)
//	{
//		$res = $model->$function()->detach();
//		return $res;
//	}
}