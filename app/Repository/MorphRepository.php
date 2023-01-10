<?php


namespace app\Repository;



use Illuminate\Database\Eloquent\Model;

class MorphRepository
{

	public static function attachOne(Model $morph, array $morphed, string $slug, bool $detach)
	{
		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
		$model = $modelName::find($morphed['id']);

		$function = $slug . ucfirst($morph->getTable());

		if ($detach) {
			return $model->$function()
				->wherePivot('slug',$slug)
				->sync([$morph->id => ['slug' => $slug]]);
		} else {
			return $model->$function()->syncWithoutDetach([$morph[0]->id => ['slug' => $slug]]);
		}
	}

	public static function attachOneNoDetach(array $morph, array $morphed, string $slug, bool $detach)
	{
		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
		$model = $modelName::find($morphed['id']);

		$function = $slug . ucfirst($morph[0]->getTable());

		if ($detach) {
			return $model->$function()
				->wherePivot('slug',$slug)
				->sync([$morph[0]->id => ['slug' => $slug]]);
		} else {
			return $model->$function()->syncWithoutDetach([$morph[0]->id => ['slug' => $slug]]);
		}
	}

	public static function attachMany(array $morphs, array $morphed, string $slug, bool $detach)
	{
		$modelName = 'app\\model\\' . ucfirst($morphed['type']);
		$model = $modelName::find($morphed['id']);

		$function = $slug . ucfirst($morphs[0]->getTable());

		if ($detach) {
			return $attached = self::attachManyDetaching($model, $morphs, $function, $slug);
		} else {
			return $attached = self::attachManyNoDetaching($model, $morphs, $function, $slug);
		}

	}

	protected static function attachManyNoDetaching($model, $morphs, $function, $slug)
	{
		$attached = [];
		foreach ($morphs as $item) {
			$res = $model->$function()->get()->contains($item);
			if (!$res) {
				$res = $model->$function()->attach([$item->id => ['slug' => $slug]]);
				$attached[] = ImageRepository::getSrcMorph($item);
			}
		}
		return $attached;
	}

	protected static function attachManyDetaching($model, $morphs, $function, $slug)
	{
		$res = $model->$function()->detach();
		return $res;
	}
}