<?php

namespace app\controller\Admin;

use app\service\AuthService\AuthService;


class CrmController extends AdminscController
{

    public function __construct()
    {
        parent::__construct();

        if (!AuthService::getUser()->isEmployee()) {
            header('Location:/auth/profile');
        }
    }

    public function actionSiteMap(): void
    {
    }


    public function actionIndex(): void
    {
//		View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
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


