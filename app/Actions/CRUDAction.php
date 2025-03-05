<?php


namespace app\Actions;


use app\Repository\MorphRepository;
use Exception;

class CRUDAction
{
	public function delete(array $req, $model){
		$id = $req['id'];

		if (!$id) $this->exitWithMsg('No id');
		$model = new $model;

		$item = $model->find((int)$id);
		if ($item) {
			$destroy = $item->delete();
			$this->exitJson(['id' => $id, 'popup' => 'Ok']);
		}
	}

	public function updateOrCreate(array $req, $model){
		if (!$req) throw new Exception('No request');

		if (isset($req['relation'])) {
			$relation = $req['relation'];
			$model = $this->model::with($relation)->find($req['id']);

			$created = $model->$relation()->create();
			$this->exitJson(['popup' => 'Создан', 'id' => $created->id]);
		}

		if (isset($req['morph'])) {
			$morph = $req['morph'];
			$relation = $morph['relation'];
			$model = $this->model::with($relation)->find($req['id']);
			$created = $model->$relation()->create();
			$model->$relation()->syncWithoutDetaching($created);
			$this->exitJson(['popup' => 'Создан', 'id' => $created->id]);
		}

		$model = $model::updateOrCreate(
			['id' => $req['id']],
			$req
		);

		if ($model->wasRecentlyCreated) {
			$this->exitJson(['popup' => 'Создан', 'id' => $model->id]);
		} else {
			$this->exitJson(['popup' => 'Обновлен', 'model' => $model->toArray()]);
		}
		$this->exitWithError('Ошибка');
	}

	public function attach(array $req){
		if (!$req) $req = $_POST;
		if ($_FILES) {
			MorphRepository::attachWithFiles($_FILES, $req);
		} else {
			MorphRepository::attach($req);
		}

		$this->exitWithPopup('ok');
	}

	public function dettach(array $req){
		if (!$req) $this->exitWithError('Плохой запрос');
		MorphRepository::detach($this, $req);
		$this->exitWithPopup('ok');
	}
}