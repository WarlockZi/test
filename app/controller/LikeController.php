<?php


namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\model\Like;

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
        $like = Like::where('user_id', Auth::getUser()->getId())
            ->get();
        $this->setVars(compact('like'));
        Response::exitJson(['liked' => 1]);
    }

    public function actionDel(): void
    {
        $req  = $this->ajax;
        $like = Like::where('user_id', Auth::getUser()->getId())
            ->where('product_id', $req['fields']['product_id'])
            ->delete();
        Response::exitJson(['disliked' => 1]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req   = $this->ajax;
        $user  = Auth::getUser();

        $field = $user ? 'user_id' : 'sess';
        $value = $user ? Auth::getUser()->getId() : session_id();
        $like = Like::updateOrCreate([
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ], [
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ]);
        Response::exitJson(['liked' => true]);



    }

}