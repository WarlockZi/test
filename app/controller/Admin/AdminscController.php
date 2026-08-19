<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\service\AuthService\AuthService;
use JetBrains\PhpStorm\NoReturn;
use Throwable;


class AdminscController extends AppController
{
    public function __construct()
    {
        $user = AuthService::getUser();
        if (!$user || (!$user->isAdmin() && !$user->isEmployee()))
            response()->redirect("/");

        parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        view('admin.index');
    }


    public function actionSiteMap(): void
    {
    }

    public function actionPics(): void
    {
    }


    public function createSiteMap()
    {
    }

    public function actionDumpSQL()
    {
    }

    public function actionDumpWWW()
    {
    }

    #[NoReturn] public function showTable(): void
    {
        $data = $this->actions->table($this->model);
        view('admin.components.table.adminTableStandAlone', compact('data'));
    }
}


