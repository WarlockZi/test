<?php

namespace app\controller\Admin;


use app\core\Response;

class CacheController extends AdminscController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function actionClear(): void
    {
        $path = ROOT . "/tmp/cache/*.txt";
        array_map("unlink", glob($path));
        Response::json(['popup' => 'Успешно']);
    }


}


