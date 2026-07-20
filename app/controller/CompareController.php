<?php


namespace app\controller;


use app\formRequest\CompareRequest;
use app\model\Compare;
use app\repository\CompareRepository;
use app\service\AuthService\Auth;
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
        $req = $request->validated();
        if (CompareRepository::del($req)) {
            response()->json(['popup'=>'Товар удален из сравнения','discompared' => true]);
        }
        response()->json(['popup'=>'Товар не добавлен в сравнения','discompared' => false]);
    }

    #[NoReturn] public function actionUpdateOrCreateCustom(CompareRequest $request): void
    {
        $req = $request->validated();
        CompareRepository::updateOrCreate($req);
        response()->json(['popup'=>'Товар добавлен для сравнения', 'compared'=>true]);
    }
}