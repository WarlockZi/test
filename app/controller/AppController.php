<?php

namespace app\controller;

use app\core\Auth;
use app\model\User;
use app\Repository\MorphRepository;
use app\view\AdminView;
use app\view\UserView;
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
//		$pref = $this->route->isAdmin() ? '/Admin' : '';
//		$controller = $this->route->controller;
		$view = $this->getView();
		$view->render();
	}


	public function getView()
	{
		if ($this->route->isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView($this);
		} else {
			return new UserView($this);
		}
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
		$req = $_POST;
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
		if ($this->ajax) {

			$model = $this->model::updateOrCreate(
				['id' => $this->ajax['id']],
				$this->ajax
			);

			if ($model->wasRecentlyCreated) {
				if (isset($this->ajax['morph_type'])) {
					$morph['morph'] = self::shortClassName($model);
					$morph['morphId'] = $model->id;
					self::attachMorph($this->ajax, $morph);
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
