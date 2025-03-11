<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\model\Promotion;
use app\view\Promotion\PromotionFormView;

class PromotionController extends AdminscController
{
    public string $model = Promotion::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionEdit(): void
    {
        $id        = $this->route->id;
        $promotion = Promotion::with('product')->firstOrCreate(['id' => $id]);
        $promotion = PromotionFormView::edit($promotion);
        $this->setVars(compact('promotion'));
    }

    public function actionIndex(): void
    {
        $promotions = Promotion::with('product', 'unit')->get();
        $content    = PromotionFormView::adminIndex($promotions);
        $this->setVars(compact('content'));
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;

        if (isset($req['relation'])) {
            $id        = $req['id'];
            $relation  = $req['relation'];
            $promotion = Promotion::with($relation)->find($id);

            $created = $promotion->$relation()->create();
            Response::json(['popup' => 'Создан', 'id' => $created->id]);
        }

        $promotion = Promotion::updateOrCreate(
            ['id' => $req['id']],
            $req
        );

        if ($promotion->wasRecentlyCreated) {
            Response::json(['popup' => 'Создан', 'id' => $promotion->id]);
        } else {
            Response::json(['popup' => 'Обновлен', 'model' => $promotion->toArray()]);
        }
        Response::json(['error' => 'Ошибка']);

    }
}
