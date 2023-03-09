<?php

namespace app\controller;

use app\Repository\MorphRepository;
use Illuminate\Database\Eloquent\Model;

class AppController extends Controller
{
	protected $ajax;

	public function __construct()
	{
		parent::__construct();
		$this->isAjax();
	}

	public function setView()
	{
		$view = $this->getView();
		$view->render();
	}

	public function actionDelete()
	{
		$id = $this->ajax['id'];

		if (!$id) $this->exitWithMsg('No id');
		$model = new $this->model;
		if ($model instanceof Model) {
			$item = $model->find((int)$id);
			if ($item) {
				$destroy = $item->delete();
				$this->exitJson(['id' => $id, 'popup' => 'Ok']);
			}
		} else {
			if ($model::delete($id)) {
				$this->exitWithPopup('Удален');
			}
		}
	}

	public function actionAttach()
	{
		$req = $this->isAjax();
		if (!$req) $this->exitWithError('Плохой запрос');
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
		MorphRepository::detach($req);
		$this->exitWithPopup('ok');
	}

	public function actionUpdateOrCreate()
	{
		$req = $this->ajax;
		if ($this->ajax) {

			if ()

			$model = $this->model::updateOrCreate(
				['id' => $this->ajax['id']],
				$this->ajax
			);

			if ($model->wasRecentlyCreated) {
				if (isset($this->ajax['morph_type'])) {
					$this->actionAttach($this->ajax, $model);
				}
				$this->exitJson(['popup' => 'Создан', 'id' => $model->id]);
			} else {
				$this->exitJson(['popup' => 'Обновлен', 'id' => $model->id]);
			}
		}
	}

	public static function shortClassName($object)
	{
		return lcfirst((new \ReflectionClass($object))->getShortName());
	}


}
