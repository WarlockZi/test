<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\service\AuthService\Auth;
use app\service\AuthService\IUser;


class AdminscController extends AppController
{
    public function __construct()
    {
        $user = Auth::getUser();
        if ($user) {
            $this->checkPermition($user);
            parent::__construct();
        }else{
            header("Location:/");
        }
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


