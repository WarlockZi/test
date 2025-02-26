<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;


class AdminscController extends AppController
{
    public function __construct()
    {
        $this->isEmployee();
        parent::__construct();

    }

    protected function isEmployee()
    {
        $user = Auth::getUser();
        if (!$user?->role->firstWhere('name', 'role_employee')) {
            if (!$user->role->firstWhere('name', 'role_admin')) {
                header("Location:/");
                exit();
            }
        }
    }

    public function actionClearCache(): void
    {
        $path = ROOT . "/tmp/cache/*.txt";
        array_map("unlink", glob($path));
        exit('Успешно');
    }


    public function actionSiteMap(): void
    {
    }

    public function actionPics(): void
    {
    }

    public function actionIndex(): void
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

}


