<?php
declare(strict_types=1);

namespace app\controller;

use app\repository\MorphRepository;
use app\service\Response;
use app\service\Router\IRequest;

class AppController extends Controller
{
    protected string $model;
    public array $settings;


    public function __construct()
    {
        parent::__construct();
    }

    public function actionUpdateOrCreate(IRequest $request): void
    {
        $req = $request->body();

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
            response()->json(['popup' => 'Создан', 'id' => $model->id]);
        } else {
            response()->json(['popup' => 'Обновлен', 'model' => $model->toArray()]);
        }
        response()->json(['error' => 'Ошибка']);
    }

    public function actionDelete(): void
    {
        $id = $this->ajax['id'];
        if (!$id) response()->json(['msg' => 'No id']);
        $model        = $this->model::find($id);
        $relationType = $this->ajax['relationType'] ?? null;
        if (!empty($relationType)) {
            $relationName = $this->ajax['relationName'] ?? null;
            if ($relationType === 'attach') {
                $relationId = $this->ajax['relationId'] ?? null;
                if ($model->$relationName()->detach($relationId)) {
                    response()->json(['deleted' => $relationId, 'popup' => 'Удален']);
                }
            }
        } else {
            $destroyed = $this->model::destroy($id);
            if ($destroyed) {
                response()->json(['id' => $id, 'popup' => 'Удален']);
            } else {
                response()->json(['popup' => 'Не удален']);
            }
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
        if (!$req) response()->json(['error' => 'Плохой запрос']);
        MorphRepository::detach($this, $req);
        Response::exitWithPopup('ok');
    }


    protected function updateOrCreateMorph(array $req): void
    {
        $morph    = $req['morph'];
        $relation = $morph['relation'];
        $model    = $this->model::with($relation)->find($req['id']);
        $created  = $this->model->$relation()->create();
        $this->model->$relation()->syncWithoutDetaching($created);
        response()->json(['popup' => 'Создан', 'id' => $created->id]);
    }



    protected function updateOrCreateRelation(array $req): void
    {
        $action       = '';
        $modalId      = $req['id'];
        $relationName = $req['relation']['name'] ?? null;
        $pivot        = $req['relation']['pivot'] ?? null;
        $attach       = $req['relation']['attach'] ?? null;
        $model        = $this->model::with($relationName)->find($modalId);

        if ($relationName) {//for has many models
            if ($pivot) {
                $id                 = $req['relation']['id'];
                $pivotField         = array_keys($pivot)[0];
                $pivotValue         = $req['relation']['pivot'][$pivotField];
                $pivot              = $model->$relationName()->find($id)->pivot;
                $pivot->$pivotField = $pivotValue;
                try {
                    $pivot->save();
                    response()->json(['popup' => 'Изменен']);
                } catch (Throwable $exception) {
                    response()->json(['popup' => 'Ошибка']);
                }
            } elseif ($attach) {
                $detach = $req['relation']['detach'] ?? null;
                if ($detach) {
                    $model->$relationName()->attach($req['relation']['attach']);
                    $model->$relationName()->detach($req['relation']['detach']);
                    response()->json(['popup' => 'Заменен', 'attach' => $attach, 'detached' => $detach]);
                } else {
                    $model->$relationName()->syncWithoutDetaching($detach);
                    response()->json(['popup' => 'Заменен', 'attach' => $attach]);
                }

            } elseif (!empty($req['relation']['fields'])) {
                $key                        = key($req['relation']['fields']) ?? null;
                $value                      = $req['relation']['fields'][$key] ?? null;
                $model->$relationName->$key = $value;
                $model->push();
            } elseif ($req['relation']['id']) {
//                $id           = $req['relation']['id'];
//                $withRelation = $model->$relationName()->syncWithoutDetaching([$id]);
            }
        }

//        if ($action === 'created') Response::exitJson(['popup' => 'Создан', 'id' => $rel->id]);

        response()->json(['popup' => 'Обновлен']);
    }


}
