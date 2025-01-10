<?php


namespace app\controller;


use app\core\Auth;
use app\core\Response;
use app\model\Compare;

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
        $compare = Compare::with('user', 'product')
            ->where('user_id', Auth::getUser()->getId())
            ->get();
        Response::exitJson(['discompared' => 1]);
    }

    public function actionDel(): void
    {
        $req     = $this->ajax;
        $compare = Compare::where('user_id', Auth::getUser()->getId())
            ->where('product_id', $req['fields']['product_id'])
            ->delete();
        Response::exitJson(['discompared' => 1]);
    }

    public function actionUpdateOrCreate(): void
    {
        $req   = $this->ajax;
        $user  = Auth::getUser();

        $field = $user ? 'user_id' : 'sess';
        $value = $user ? Auth::getUser()->getId() : session_id();
        $c = Compare::updateOrCreate([
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ], [
            $field => $value,
            'product_id' => $req['fields']['product_id'],
        ]);
        Response::exitJson(['compared' => 1]);


    }
}