<?php


namespace app\Repository;

use app\controller\AppController;

class MorphRepository extends AppController
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

	public static function attachWithFiles(array $files, array $req): bool
	{
		$morphed = $req['morphedType'];
		$morphedId = $req['morphedId'];
		$model = self::getModelName($morphed)::find($morphedId);
		$func = $req['func'];

		$errors = [];
		foreach ($files as $file) {
			ImageRepository::saveToFile($model, $file);
			if (ImageRepository::saveToFile()) {
				$res = $model->$func()->syncWithoutDetaching($morphedId);

			} else {
			}

		}


//		$slug = $morphed['slug'];

//		if ($morphed['detach'] === 'true') {
//			$res = $model->$func()
//				->wherePivot('slug', $slug)
//				->sync([$morphed['id'] => ['slug' => $slug]]);
//			return true;
//		} else {

//		}
	}

	public static function detach(array $req)
	{
		$model = 'app\model\\' . ucfirst($req['morphedType']);
		$id = $req['morphId'];
		$model = $model::find($req['morphedId']);

		$f = $req['funct'];
		$res = $model->$f()->detach($id);
		if ($res) {
			exit(json_encode(['poppup' => 'ok']));
		} else {
			exit(json_encode(['poppup' => 'ошибка']));
		}
	}

}