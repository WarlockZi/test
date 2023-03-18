<?php


namespace app\Repository;

use app\controller\AppController;
use app\controller\Controller;

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
		$relation = $morphed['relation'];
		$model = self::getModelName($morph['model'])::with($relation)->find($morph['id']);
		$slug = $morphed['slug'];
		if ($morphed['oneOrMany'] === 'one') {
			$res = $model->$relation()
				->wherePivot('slug', $slug)
				->sync([$morphed['id'] => ['slug' => $slug]]);
			return true;
		} else {
			$res = $model->$relation()
				->wherePivot('slug', $slug)
				->syncWithoutDetaching([$morphed['id'] => ['slug' => $slug]]);
			return true;
		}
	}

	public static function attachWithFiles(array $files, array $req)
	{
		$self = new self;
		$model = $req['model'];
		$id = $req['id'];
		$morph = $req['morph'];

		$relationName = $morph['relation'];
		$oneOrMany = $morph['oneormany'];
		$slug = $morph['slug'];
		$path = $morph['path'];

		$model = self::getModelName($model)::with($relationName)->find($id);
		$relation = $model->$relationName();
		$repository = $relation->getRelated()->getRepo();

		if ($oneOrMany === 'one') {
			$file = $files[0];
			$repository::validate($file);
			$morph = $repository->firstOrCreate($file, $path);

			if ($morph->wasRecentlyCreated) {
				$repository::saveToFile($morph, $file, $path);
			}

			$res = $model->$relationName()
				->wherePivot('slug', $slug)
				->sync([$morph['id'] => ['slug' => $slug]]);
			$image['src'] = $morph->getFullPath();
			$image['id'] = $morph->id;

			$self->exitJson([$image]);
		} else {
			$ids = [];
			$images = [];
			foreach ($files as $file) {
				$repository::validate($file);
				$morph = $repository->firstOrCreate($file, $path);
				if ($morph->wasRecentlyCreated) {
					$repository::saveToFile($morph, $file, $path);
				}
				$ids[] = $morph->id;
				$image['src'] = $morph->getFullPath();
				$image['id'] = $morph->id;
				$images[] = $image;
				$res = $model->$relationName()
					->wherePivot('slug', $slug)
					->sync([$morph['id'] => ['slug' => $slug]], false);
				$res = $model->$relationName()->sync([$morph->id], false);
			}
			$self->exitJson($images);

//			$res = $model->$relationName()->sync($ids);
			exit();
		}

	}

	public static function detach(Controller $controller, array $req)
	{
		$self = new self;
		$relation = $req['relation'];
		$morphId = $req['morphId'];
		$model = $controller->model::with($relation)->find($req['id']);
		$res = $model->$relation()->detach($morphId);

		if ($res) {
			$self->exitWithSuccess('ok');
		} else {
			exit(json_encode(['poppup' => 'ошибка']));
		}
	}

}