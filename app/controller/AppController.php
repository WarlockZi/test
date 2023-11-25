<?php

namespace app\controller;

use app\controller\Interfaces\IModelable;
use app\Repository\MorphRepository;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;
use ReflectionClass;

class AppController extends Controller implements IModelable
{
	protected $model;

	public function __construct()
	{
		parent::__construct();
	}

	public function setView(string $type = '')
	{
		if ($type === 'notFound') {
			$view = $this->getView();
		}
		$view = $this->getView();
		$view->render();
	}

	public function actionDelete()
	{
		$id = $this->ajax['id'];

		if (!$id) $this->exitWithMsg('No id');
		$model = new $this->model;

		$item = $model->find((int)$id);
		if ($item) {
			$destroy = $item->delete();
			$this->exitJson(['id' => $id, 'popup' => 'Ok']);
		}
	}

	public function actionAttach()
	{
		$req = $this->isAjax();
//		$this->exitWithPopup(var_dump($req));
		if (!$req) $req = $_POST;
		if ($_FILES) {
			MorphRepository::attachWithFiles($_FILES, $req);
		} else {
			MorphRepository::attach($req);
		}

		$this->exitWithPopup('ok');
	}

	public function actionDetach()
	{
		$req = $this->ajax;
		if (!$req) $this->exitWithError('Плохой запрос');
		MorphRepository::detach($this, $req);
		$this->exitWithPopup('ok');
	}


	public function actionUpdateOrCreate()
	{
		$req = $this->ajax;
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

		$model = $this->model::updateOrCreate(
			['id' => $req['id']],
			$req
		);

		if ($model->wasRecentlyCreated) {
			$this->exitJson(['popup' => 'Создан', 'id' => $model->id]);
		} else {
			$this->exitJson(['popup' => 'Обновлен', 'id' => $model->id]);
		}
		$this->exitWithError('Ошибка');

	}

	public static function shortClassName($object)
	{
		return lcfirst((new ReflectionClass($object))->getShortName());
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}

}
