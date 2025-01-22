<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
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
        $iniCatList = App::$app->category->getInitCategories();
        $this->setVars(compact('iniCatList'));
    }

    public function actionPics(): void
    {
        $pics = App::$app->adminsc->findAll('pic');
        $this->setVars(compact('pics'));
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


