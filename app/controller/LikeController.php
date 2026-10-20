<?php


namespace app\controller;


use app\formRequest\LikeRequest;
use app\model\Like;
use app\repository\LikeRepository;
use app\service\Like\LikeService;
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

    #[NoReturn]
    public function actionIndex(LikeService $service): void
    {
        $liked_products   = $service->index();
//        $content = LikeView::all($liked_products);
        view('pages.likes', compact(
//            'content',
            'liked_products'));
    }

    #[NoReturn]
    public function actionDel(LikeRequest $request): void
    {
        if (LikeRepository::del($request)) {
            response()->json(['id' => $request['id']]);
        }
        response()->json(['disliked' => false]);
    }

    #[NoReturn]
    public function actionUpdateOrCreateCustom(LikeRequest $request): void
    {
        if (LikeRepository::updateOrCreate($request)) {
            response()->json(['liked' => true]);
        }
        response()->json(['liked' => false]);
    }

    #[NoReturn]
    public function actionToggle(LikeRequest $request, LikeService $service): void
    {
        $request = $request->validated();

        $liked = $service->toggle($request);

        response()->json(['liked' => $liked]);
    }
}