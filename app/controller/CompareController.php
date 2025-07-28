<?php


namespace app\controller;


use app\formRequest\CompareRequest;
use app\model\Compare;
use app\repository\CompareRepository;
use app\service\AuthService\Auth;
use app\service\Response;
use app\view\Compare\CompareView;
use JetBrains\PhpStorm\NoReturn;


class CompareController extends AppController
{
    public function __construct(
        public string $model = Compare::class,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionPage(): void
    {
        $compares = CompareRepository::all();
//        $content  = CompareView::all($compares);
        view('pages.compares', compact('compares'));
    }

    #[NoReturn] public function actionDel(CompareRequest $request): void
    {
        if (CompareRepository::del($request)) {
            response()->json(['discompared' => true]);
        }
        response()->json(['discompared' => false]);
    }

    #[NoReturn] public function actionUpdateOrCreateCustom(CompareRequest $request): void
    {
        list($field, $value) = Auth::getCartFieldValue();

        Compare::updateOrCreate([
            $field => $value,
            'product_id' => $request['fields']['product_id'],
        ], [
            $field => $value,
            'product_id' => $request['fields']['product_id'],
        ]);
        response()->json(['compared' => 1]);
    }
}