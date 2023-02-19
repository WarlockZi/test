<?php

namespace app\controller;

use app\core\Auth;
use app\core\Router;
use app\model\User;
use app\Repository\MorphRepository;
use app\view\AdminView;
use app\view\UserView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

class AppController extends Controller
{
	protected $ajax;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->isAjax();
	}

	public function setView()
	{
		$pref = Router::isAdmin()?'/Admin':'';
		$controller = $this->route['controller'];
  	$this->layout = ROOT."/app/view/layouts/{$this->layout}.php";
  	$this->view = ROOT."/app/view/{$controller}{$pref}/{$this->view}.php";
  	$view = $this->getView();
  	$view->render();
	}
	protected function setLayout()
	{
		if (Router::isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
			return ROOT.'/app/view/layouts/admin.php';
		} else {
			return ROOT.'/app/view/layouts/vitex.php';
		}
	}

	public function getView()
	{
		if (Router::isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView($this->route);
		} else {
			return new UserView($this->route);
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
		$req = $this->ajax;
		if (!$req) $this->exitWithError('Плохой запрос');
		if (!isset($req['morph'])) $this->exitWithError('Плохой запрос');
		MorphRepository::attach($req);
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
