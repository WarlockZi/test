<?php


namespace app\controller;


use app\core\Response;
use app\model\Like;
use app\Repository\LikeRepository;
use app\view\Like\LikeView;

class LikeController extends AppController
{
    public string $model = Like::class;
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function actionPage(): void
    {
        $likes   = LikeRepository::all();
        $content = LikeView::all($likes);
        $this->setVars(compact('content'));
    }

    public function actionDel(): void
    {
        $req = $this->ajax;
        if (LikeRepository::del($req)) {
            Response::json(['id' => $req['id']]);
        }
        Response::json(['disliked' => false]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        if (LikeRepository::updateOrCreate($req)) {
            Response::json(['liked' => true]);
        }
        Response::json(['liked' => false]);
    }

}