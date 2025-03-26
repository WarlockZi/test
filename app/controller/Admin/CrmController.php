<?php

namespace app\controller\Admin;

use app\Services\AuthService\Auth;


class CrmController extends AdminscController
{

    public function __construct()
    {
        parent::__construct();

        if (!Auth::userIsEmployee()) {
            header('Location:/auth/profile');
        }
    }

//    public function actionClearCache(): void
//    {
//        $path = ROOT . "/tmp/cache/*.txt";
//        array_map("unlink", glob($path));
//        exit('Успешно');
//    }

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


