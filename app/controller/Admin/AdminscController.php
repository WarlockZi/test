<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\core\IUser;
use app\view\View;


class AdminscController extends AppController
{
    public function __construct()
    {
        $user = Auth::getUser();
        if ($user) {
            $this->checkPermition($user);
            parent::__construct();
        }
            header("Location:/");
//        return View::noPermition();
    }

    protected function checkPermition(IUser $user): void
    {
        $roles = $user->role()->get();
        if (!$roles->contains('name', '=', 'role_admin')
            && !$roles->contains('name', '=', 'role_employee')) {
            header("Location:/");
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


