<?php

namespace app\controller\Admin;

use app\blade\views\admin\promotion\PromotionFormView;
use app\model\Promotion;

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
        $data    = PromotionFormView::adminIndex($promotions);
        view('admin.promotion.promotion', compact('data'));
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;

        if (isset($req['relation'])) {
            $id        = $req['id'];
            $relation  = $req['relation'];
            $promotion = Promotion::with($relation)->find($id);

            $created = $promotion->$relation()->create();
            response()->json(['popup' => 'Создан', 'id' => $created->id]);
        }

        $promotion = Promotion::updateOrCreate(
            ['id' => $req['id']],
            $req
        );

        if ($promotion->wasRecentlyCreated) {
            response()->json(['popup' => 'Создан', 'id' => $promotion->id]);
        } else {
            response()->json(['popup' => 'Обновлен', 'model' => $promotion->toArray()]);
        }
        response()->json(['error' => 'Ошибка']);

    }
}
