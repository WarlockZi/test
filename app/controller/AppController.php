<?php

namespace app\controller;

use app\core\Response;
use app\Repository\MorphRepository;
use Illuminate\Database\Eloquent\Model;

class AppController extends Controller
{
    protected string $model;
    public array $settings;

    public function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        if ($this->isAjax()) exit;
//        $response = new Response();
//        $response->view();

//        $this->view  = $this->route->getActionName();
//        $layout = $this->route->getLayout();
//        $layout = new $layout($this->route, $this);
//        $layout->render();
//        exit();
    }



    public function actionDelete(): void
    {
        $id = $this->ajax['id'];

        if (!$id) Response::exitWithMsg('No id');
        $model = new $this->model;

        $item = $model::find($id);
        if ($item) {
            $destroy = $item->delete();
            Response::exitJson(['id' => $id, 'popup' => 'Ok']);
        }
    }

    public function actionAttach(): void
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

    public function actionDetach(): void
    {
        $req = $this->ajax;
        if (!$req) Response::exitWithError('Плохой запрос');
        MorphRepository::detach($this, $req);
        Response::exitWithPopup('ok');
    }

    protected function updateOrCreateRelation(array $req): void
    {
        $action   = '';
        $parentId = $req['id'];
        $relation = $req['relation'];
        $id       = $req['fields']['id'] ?? null;
        $fields   = $req['fields'];
        $model    = $this->model::with($relation)->find($parentId);
        if ($id) {
            $rel = $model->$relation->find($id)->updateOrCreate(
                ['id' => $id],
                $fields);
            if ($rel->wasRecentlyCreated) Response::exitJson(['popup' => 'Создан', 'id' => $rel->id]);
        } else {
            if ($model->$relation === null) {
                $action = 'created';
                $rel    = $model->$relation()->create($fields);
            } else {
                $action = 'updated';
                $rel    = $model->$relation()->update($fields);
            }
        }
        if ($action === 'created') Response::exitJson(['popup' => 'Создан', 'id' => $rel->id]);

        Response::exitJson(['popup' => 'Обновлен']);
    }
    protected function updateOrCreateMorph(array $req):void
    {
        $morph    = $req['morph'];
        $relation = $morph['relation'];
        $model    = $this->model::with($relation)->find($req['id']);
        $created  = $this->model->$relation()->create();
        $this->model->$relation()->syncWithoutDetaching($created);
        Response::exitJson(['popup' => 'Создан', 'id' => $created->id]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        if (isset($req['relation'])) {
            $this->updateOrCreateRelation($req);
        }
        if (isset($req['morph'])) {
            $this->updateOrCreateMorph($req);
        }

        $model = $this->model::updateOrCreate(
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


    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel($model): void
    {
        $this->model = $model;
    }

}
