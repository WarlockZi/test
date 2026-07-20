<?php

namespace app\repository;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdateOrCreateRepository
{
    private string $model;
    private string $modelId;
    private string $relationName;
    private string $relationId;
    private array $relationField;
    private string $pivotName;
    private string $pivotId;
    private array $pivotField;
    private array $field;


    public static function process(array $req, string $modelClass): Response
    {
        try {
            $self = self::createSelf($req, $modelClass);
            $self->validateRequest($req);

            if (!empty($self->relationName)) {
                return $self->handleRelation($req, $modelClass);
            }

            if (!empty($self->pivotName)) {
                return $self->handlePivot($req, $modelClass);
            }

            if (!empty($self->field)) {
                return $self->handleMainModel($req, $modelClass);
            }

            return response()->json(['error' => 'Нет данных для обновления'], 400);

        } catch (Throwable $exception) {
            env('VITE_DEV') ? null : error_log('UpdateOrCreateRepository failed - ' . $exception->getMessage());

            return response()->json([
                'error' => 'Ошибка ' . __CLASS__,
                'message' => env('VITE_DEV') ? $exception->getMessage() : null
            ], 500);
        }
    }

    private static function createSelf(array $req, string $modelClass): UpdateOrCreateRepository
    {
        $self          = new self();
        $self->model   = $modelClass ?? '';
        $self->modelId = $req['id'] ?? '';

        $self->relationName = $req['relation']['name'] ?? '';
        $self->relationId   = $req['relation']['id'] ?? '';
        $self->relationField   = $req['relation']['field'] ?? [];

        $self->pivotName = $req['pivot']['name'] ?? '';
        $self->pivotId   = $req['pivot']['id'] ?? '';
        $self->pivotField   = $req['pivot']['field'] ?? [];

        $self->field = $req['field'] ?? [];
        return $self;
    }

    #[NoReturn]
    private static function handlePivot(array $req, string $modelClass): Response
    {
        $modelId = $req['id'];

        $pivotData    = $req['pivot'];
        $pivotId      = $pivotData['id'] ?? null;
        $relationName = $pivotData['name'];
        $fieldValue   = $pivotData['field'];

        if (!$pivotId) {
            return response()->json(['error' => "Отсутсвует id основной модели"], 400);
        }

        $res = $modelClass::find($modelId)->$relationName()->wherePivot('id', $pivotId)->update($fieldValue);

        if ($res) {
            return response()->json(['popup' => "pivot $relationName обновленa успешно"]);
        }

        return response()->json(['error' => 'Ошибка обновления pivot'], 500);
    }

    private function validateRequest($req): void
    {
        if (empty($this->model)) {
            throw new \InvalidArgumentException("Отсутствует name основной модели");
        }
        if (!class_exists($this->model)) {
            throw new \InvalidArgumentException("Класс основной модели не найден");
        }

        if (empty($req)) {
            throw new \InvalidArgumentException('Request data is empty');
        }
        if (empty($req['id'])) {
            throw new \InvalidArgumentException("Отсутсвует id основной модели");
        }

        if ((empty($req['relation']['name']) && empty($req['pivot']['name'])) && empty($req['field'])) {
            throw new \InvalidArgumentException("Either relation/pivot or field must be provided");
        }
    }

    #[NoReturn]
    private static function handleMainModel(array $req, string $modelClass): Response
    {
        $id     = $req['id'] ?? null;
        $fields = $req['field'];

        $criteria = $id ? [] : ['id' => $id];

        $model = $modelClass::updateOrCreate($criteria, $fields);

        if ($model->wasRecentlyCreated) {
            return response()->json([
                'popup' => 'Создан успешно',
                'id' => $model->id,
            ], 201);
        }

        if ($model->wasChanged()) {
            return response()->json([
                'popup' => 'Обновлен успешно',
            ]);
        }

        return response()->json([
            'popup' => 'Изменений не внесено',
        ]);
    }

    private function handleRelation(): Response
    {
        if ($this->relationId) {
            $result = $this->model::find($this->modelId)
                ->{$this->relationName}()
                ->update($this->relationField);
            return response()->popup('Обновлена зависимая модель', 200);
        } else {
//            $model = $this->model::with($this->relationName)->find($this->modelId);
            $result = $this->model::find($this->modelId)
                ->{$this->relationName}()
                ->update($this->relationField);
            return response()->popup('Обновлена '.$this->relationName, 200);
        }
        return response()->json(['error' => 'Неизвестный тип операции с отношением'], 500);
    }

    private static function updatePivot(Model $model, string $relationName, array $data): Response
    {
        $relatedId = $data['id'] ?? null;
        $pivotData = $data['pivot'];

        if (!$relatedId || empty($pivotData)) {
            throw new \InvalidArgumentException('Pivot update requires related ID and pivot data');
        }

        $pivotField = array_keys($pivotData)[0];
        $pivotValue = $pivotData[$pivotField];

        // Используем встроенный метод Laravel
        $model->$relationName()->updateExistingPivot($relatedId, [$pivotField => $pivotValue]);

        return response()->json(['popup' => 'Pivot обновлен успешно']);
    }

    private static function handleAttachDetach(Model $model, string $relationName, array $data): Response
    {
        $attachIds = $data['attach'];
        $detachIds = $data['detach'] ?? null;

        if (empty($attachIds)) {
            throw new \InvalidArgumentException('Attach IDs are required');
        }

        $attachIds = is_array($attachIds) ? $attachIds : [$attachIds];

        if ($detachIds !== null) {
            // Специальный случай: detach === '0' означает только добавление
            if ($detachIds === '0' || $detachIds === 0) {
                $model->$relationName()->attach($attachIds);

                return response()->json([
                    'popup' => 'Связь создана',
                    'attached' => $attachIds
                ]);
            }

            $detachIds = is_array($detachIds) ? $detachIds : [$detachIds];
            $model->$relationName()->detach($detachIds);
            $model->$relationName()->attach($attachIds);

            return response()->json([
                'popup' => 'Связи заменены',
                'attached' => $attachIds,
                'detached' => $detachIds
            ]);
        }

        $model->$relationName()->syncWithoutDetaching($attachIds);

        return response()->json([
            'popup' => 'Связи добавлены',
            'attached' => $attachIds
        ]);
    }

    private static function updateRelatedField(Model $model, string $relationName, array $data): Response
    {
        $fieldData = $data['field'];
        $relatedId = $data['id'] ?? null;

        $key   = key($fieldData);
        $value = $fieldData[$key] ?? null;

        if (!$key || $value === null) {
            throw new \InvalidArgumentException('Field key and value are required');
        }

        $relatedModel = $model->$relationName;

        if ($relatedModel instanceof Model) {
            $relatedModel->update([$key => $value]);

            return response()->json(['popup' => 'Поле обновлено']);
        }

        if ($relatedModel instanceof Collection) {
            if (!$relatedId) {
                throw new \InvalidArgumentException('ID required for updating collection relations');
            }

            $targetModel = $relatedModel->find($relatedId);

            if (!$targetModel) {
                throw new ModelNotFoundException(
                    "Related model with ID {$relatedId} not found in {$relationName}"
                );
            }

            $targetModel->update([$key => $value]);

            return response()->json(['popup' => 'Поле обновлено']);
        }

        throw new \InvalidArgumentException("Unsupported relation type for {$relationName}");
    }

    private static function getRelationType($model, $relationName)
    {
        $relation = $model->$relationName();

        $typeMap = [
            HasOne::class => 'hasOne',
            HasMany::class => 'hasMany',
            BelongsTo::class => 'belongsTo',
            BelongsToMany::class => 'belongsToMany',
            HasManyThrough::class => 'hasManyThrough',

            MorphTo::class => 'morphTo',
            MorphMany::class => 'morphMany',
            MorphOne::class => 'morphOne',
            MorphToMany::class => 'morphToMany',
            MorphedByMany::class => 'morphedByMany',
        ];

        return $typeMap[get_class($relation)] ?? 'unknown';
    }
}
