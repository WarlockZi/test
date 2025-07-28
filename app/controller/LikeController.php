<?php


namespace app\controller;


use app\formRequest\LikeRequest;
use app\model\Like;
use app\repository\LikeRepository;
use app\service\Response;
use app\view\Like\LikeView;
use JetBrains\PhpStorm\NoReturn;

class LikeController extends AppController
{
    public string $model = Like::class;

    public function __construct()
    {
        parent::__construct();
    }

    #[NoReturn] public function actionPage(): void
    {
        $likes   = LikeRepository::all();
        $content = LikeView::all($likes);
        Response::view('pages.likes', compact('content'));
    }

    #[NoReturn] public function actionDel(LikeRequest $request): void
    {
        if (LikeRepository::del($request)) {
            response()->json(['id' => $request['id']]);
        }
        response()->json(['disliked' => false]);
    }

    #[NoReturn] public function actionUpdateOrCreateCustom(LikeRequest $request): void
    {
        if (LikeRepository::updateOrCreate($request)) {
            response()->json(['liked' => true]);
        }
        response()->json(['liked' => false]);
    }

}