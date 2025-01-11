<?php


namespace app\controller;


use app\core\Response;
use app\model\Like;
use app\Repository\LikeRepository;
use app\view\Like\LikeView;

class LikeController extends AppController
{
    public function __construct(
        public string $model = Like::class,
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
            Response::exitJson(['disliked' => true]);
        }
        Response::exitJson(['disliked' => false]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req = $this->ajax;
        if (LikeRepository::updateOrCreate($req)) {
            Response::exitJson(['liked' => true]);
        }
        Response::exitJson(['liked' => false]);


    }

}