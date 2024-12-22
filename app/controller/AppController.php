<?php

namespace app\controller;

use app\core\Response;
use app\Repository\MorphRepository;
use Throwable;

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
    }

    public function actionDelete(): void
    {
        $id = $this->ajax['id'];
        if (!$id) Response::exitWithMsg('No id');

        $destroyed = $this->model::destroy($id);
        if ($destroyed) {
            Response::exitJson(['id' => $id, 'popup' => 'Удален']);
        } else {
            Response::exitJson(['popup' => 'Не удален']);
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
        $action       = '';
        $modalId      = $req['id'];
        $relationName = $req['relation']['name'];
        $pivot        = $req['relation']['pivot'];
        $model        = $this->model::with($relationName)->find($modalId);

        if ($relationName) {//for has many models
            if ($pivot) {
                if (!$req['relation']['pivot']['field']) {
                    Response::exitJson(['popup' => 'Добавлен','success' => true]);
                }
                $id                 = $req['relation']['id'];
                $pivotField         = $req['relation']['pivot']['field'];
                $pivotValue         = $req['relation']['pivot']['value'];
                $pivot              = $model->$relationName()->find($id)->pivot;
                $pivot->$pivotField = $pivotValue;
                try {
                    $pivot->save();
                    Response::exitJson(['popup' => 'Изменен']);
                } catch (Throwable $exception) {
                    Response::exitJson(['popup' => 'Ошибка']);
                }
            }
            if (!empty($req['relation']['fields'])) {
                $key                        = key($req['relation']['fields']) ?? null;
                $value                      = $req['relation']['fields'][$key] ?? null;
                $model->$relationName->$key = $value;
//                    $withRelation = $model->$relationName->$key = $value;
//                    $withRelation = $model->$relationName->pivot->$key = $value;
                $model->push();
            } else if ($req['relation']['id']) {
                $id           = $req['relation']['id'];
                $withRelation = $model->$relationName()->syncWithoutDetaching([$id]);
            } else if ($req['relation']['id'] === 0) {
                $withRelation = $model->$relationName()->attach($model->$relationName[1]);
            }
        }

        if ($action === 'created') Response::exitJson(['popup' => 'Создан', 'id' => $rel->id]);

        Response::exitJson(['popup' => 'Обновлен']);
    }

    protected function updateOrCreateMorph(array $req): void
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
        if (!empty($req['relation']['name'])) {
            $this->updateOrCreateRelation($req);
        }
        if (!empty($req['fields'])) {
            $id    = $req['id'] ?? null;
            $model = $this->model::updateOrCreate(
                ['id' => $id],
                $req['fields']
            );
        }
        if (!empty($req['morph'])) {
            $this->updateOrCreateMorph($req);
        }

        if ($model->wasRecentlyCreated) {
            Response::exitJson(['popup' => 'Создан', 'id' => $model->id]);
        } else {
            Response::exitJson(['popup' => 'Обновлен', 'model' => $model->toArray()]);
        }
        Response::exitWithError('Ошибка');
    }

}
