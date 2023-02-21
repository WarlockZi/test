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

	public static function attachWithFiles(array $files, array $req)
	{
		$morphedType = $req['morphedType'];
		$morphedId = $req['morphedId'];

		$oneOrMany = $req['oneOrMany'];
		$slug = $req['slug'];
		$path = $req['path'];
		$func = $req['func'];

		$model = self::getModelName($morphedType)::find($morphedId);
		$relation = $model->$func();
		$repository = $relation->getRelated()->getRepo();

		if ($oneOrMany=== 'one') {
			$file = $files[0];
			$repository::validate($file);
			$morph = $repository->firstOrCreate($file, $path);

			if ($morph->wasRecentlyCreated) {
				$repository::saveToFile($morph, $file, $path);
			}
			$slug = 'main';
			$res = $model->$func()
				->wherePivot('slug', $slug)
				->sync([$morph['id'] => ['slug' => $slug]]);

			exit();
		} else {
			$file = $files[0];
			$repository::validate($file);
			$morph = $repository->firstOrCreate($file, $path);

			if ($morph->wasRecentlyCreated) {
				$repository::saveToFile($morph, $file, $path);
			}
			$res = $model->mainImages()->attach($morph->id);

			exit();

		}
//		$slug = $morphed['slug'];
//		if ($morphed['detach'] === 'true') {
//			$res = $model->$func()
//				->wherePivot('slug', $slug)
//				->sync([$morphed['id'] => ['slug' => $slug]]);
//			return true;
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