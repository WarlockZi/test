<?php

namespace app\controller;

use app\core\Auth;
use app\Repository\MorphRepository;
use app\view\Header\Header;
use app\view\View;
use Illuminate\Database\Eloquent\Model;

class AppController extends Controller
{
  protected $ajax;
  public $user;
  public $modelName;
  public $model;

  public function __construct(array $route)
  {
    parent::__construct($route);

    if (isset($route['admin'])) {
      $this->setAdminAssets();
      Auth::autorize($this);
      Header::getAdninHeader($this);
    } else {
      $this->setMainAssets();
      Header::getVitexHeader($this);
    }
    $this->isAjax();
  }

  public static function shortClassName($object)
  {
    return lcfirst((new \ReflectionClass($object))->getShortName());
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
//
//	protected static function attachMorph(array $response, array $morph)
//	{
//		if ($response['morph_oneormany'] === 'one') {
//			if ($response['morph_detach'] === 'true') {
//				ListMorphRepository::attachOneDetach($response, $morph);
//			}
//			ListMorphRepository::attachOneNoDetach($response, $morph);
//		} else {
//			if ($response['morph_detach'] === 'true') {
//				ListMorphRepository::attachOneDetach($response, $morph);
//			}
//			ListMorphRepository::attachOneNoDetach($response, $morph);
//		}
//	}

  public function actionAttach()
  {
    $req = $this->ajax;
    if (!$req) $this->exitWithError('Плохой запрос');
    if (!isset($req['morph'])) $this->exitWithError('Плохой запрос');
    MorphRepository::attach($req);
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

  public function exitJson(array $arr = []): void
  {
    if ($arr) {
      exit(json_encode(['arr' => $arr]));
    }
  }

  public function exitWithPopup(string $msg): void
  {
    if ($msg) {
      exit(json_encode(['popup' => $msg]));
    }
    exit();
  }

  public function exitWithMsg(string $msg): void
  {
    if ($msg) {
      exit(json_encode(['msg' => $msg]));
    }
    exit();
  }

  public function exitWithSuccess(string $msg): void
  {
    if ($msg) {
      exit(json_encode(['success' => $msg]));
    }
    exit();
  }

  public function exitWithError(string $msg): void
  {
    if ($msg) {
      exit(json_encode(['error' => $msg]));
    }
    exit();
  }

  protected function setMainAssets()
  {
    $this->layout = 'vitex';
    View::setJs('main.js');
    View::setCss('main.css');
    View::setJs('mainHeader.js');
    View::setCss('mainHeader.css');
//		View::setJs('breadcrumbs.js');
//		View::setCss('breadcrumbs.css');
    View::setJs('cookie.js');
    View::setCss('cookie.css');

    View::setJs('list.js');
    View::setCss('list.css');

    View::setCss('product.css');
//		View::setJs('list.css');
  }

  protected function setAdminAssets()
  {
    $this->layout = 'admin';
    View::setJs('admin.js');
    View::setCss('admin.css');
    View::setJs('list.js');
    View::setCss('list.css');
    View::setJs('common.js');
    View::setCss('common.css');
  }


}
