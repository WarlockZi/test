<?php

namespace app\controller\Admin;

use app\model\Pages;
use app\Repository\PagesRepository;

class PagesController extends AdminscController
{
    public string $model = Pages::class;
    private PagesRepository $repo;

    public function __construct(){
        parent::__construct();

        $this->repo = new PagesRepository();
    }

    public function actionIndex():void
    {
        $menu = $this->repo->menu();
        $this->setVars(compact('menu'));

    }

}