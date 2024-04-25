<?php

namespace app\controller;

use app\controller\Interfaces\IModelable;
use app\core\Response;
use app\Repository\MorphRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class AppController extends Controller implements IModelable
{
	protected $model;
	public array $settings;

	public function __construct()
	{
		parent::__construct();
//		$this->settings = (new SettingsRepository())->initial();
	}

	public function setView():void
	{
		$view = $this->getView();
		$view->render();
	}

	public function actionDelete():void
	{
		$id = $this->ajax['id'];

		if (!$id) Response::exitWithMsg('No id');
		$model = new $this->model;

		$item = $model->find((int)$id);
		if ($item) {
			$destroy = $item->delete();
			Response::exitJson(['id' => $id, 'popup' => 'Ok']);
		}
	}

	public function actionAttach():void
	{
		$req = $this->ajax;

		if (!$req) $req = $_POST;
		if ($_FILES) {
			MorphRepository::attachWithFiles($_FILES, $req);
		} else {
			MorphRepository::attach($req);
		}

		Response::exitWithPopup('ok');
	}

	public function actionDetach():void
	{
		$req = $this->ajax;
		if (!$req) Response::exitWithError('Плохой запрос');
		MorphRepository::detach($this, $req);
		Response::exitWithPopup('ok');
	}


	/**
	 * @throws Exception
	 */
	public function actionUpdateOrCreate():void
	{
		$req = $this->ajax;
		if (!$req) throw new Exception('No request');

		if (isset($req['relation'])) {
			$relation = $req['relation'];
			$model = $this->model::with($relation)->find($req['id']);

			$created = $model->$relation()->create();
			Response::exitJson(['popup' => 'Создан', 'id' => $created->id]);
		}

		if (isset($req['morph'])) {
			$morph = $req['morph'];
			$relation = $morph['relation'];
			$model = $this->model::with($relation)->find($req['id']);
			$created = $model->$relation()->create();
			$model->$relation()->syncWithoutDetaching($created);
			Response::exitJson(['popup' => 'Создан', 'id' => $created->id]);
		}

		$model = $this->model::withTrashed()
		->updateOrCreate(
			['id' => $req['id']],
			$req
		);

		if ($model->wasRecentlyCreated) {
			Response::exitJson(['popup' => 'Создан', 'id' => $model->id]);
		} else {
			Response::exitJson(['popup' => 'Обновлен', 'model' => $model->toArray()]);
		}
		Response::exitWithError('Ошибка');

	}

	public static function shortClassName($object):string
	{
		return lcfirst((new ReflectionClass($object))->getShortName());
	}

	public function getModel():Model
	{
		return $this->model;
	}

	public function setModel($model):void
	{
		$this->model = $model;
	}

}
