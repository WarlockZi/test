<?php
declare(strict_types=1);

namespace app\controller;

use app\repository\UpdateOrCreateRepository;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;

class AppController extends Controller
{
    protected string $model;
    public array $settings;


    public function __construct()
    {
        parent::__construct();
    }


    #[NoReturn]
    public function actionUpdateOrCreate(IRequest $request): void
    {
        UpdateOrCreateRepository::process($request->body(), $this->model);
    }

    public function actionDelete(IRequest $request): void
    {
        $body = $request->body();
        if (!$body['id']) response()->json(['msg' => 'No id']);
        $model    = $this->model::find($body['id']);
        $relation = $body['relation'] ?? null;
        if (!empty($relation)) {
            $relationName = $relation['name'] ?? null;
            if ($relation['attach']) {
                $relationId = $relation['attach'] ?? null;
                if ($model->$relationName()->detach((int)$relationId)) {
                    response()->json(['id' => $relationId, 'popup' => 'Удален']);
                } elseif ($model->$relationName()->where($relationName . '_id', (int)$relationId)->exists()) {
                    $model->$relationName()->detach($relationId);
                    response()->json(['message' => 'Role removed']);
                }
            }
        } else {
            $destroyed = $this->model::destroy($body['id']);
            if ($destroyed) {
                response()->json(['id' => $body['id'], 'popup' => 'Удален']);
            } else {
                response()->json(['popup' => 'Не удален']);
            }
        }
    }

}
