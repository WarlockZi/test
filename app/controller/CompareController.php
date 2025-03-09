<?php


namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\model\Compare;
use app\Repository\CompareRepository;
use app\view\CompareView\CompareView;


class CompareController extends AppController
{
    public function __construct(
        public string $model = Compare::class,
    )
    {
        parent::__construct();
    }

    public function actionPage(): void
    {
        $compares = CompareRepository::all();
        $content  = CompareView::all($compares);
        $this->setVars(compact('content'));

    }

    public function actionDel(): void
    {
        $req = $this->ajax;
        if (CompareRepository::del($req)) {
            Response::json(['discompared' => true]);
        }
        Response::json(['discompared' => false]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        list($field, $value) = Auth::getCartFieldValue();

        $c = Compare::updateOrCreate([
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ], [
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ]);
        Response::json(['compared' => 1]);


    }
}