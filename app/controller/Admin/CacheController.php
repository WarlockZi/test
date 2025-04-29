<?php

namespace app\controller\Admin;


use app\service\Response;

class CacheController extends AdminscController
{

    public function __construct(
        private readonly string $path = ROOT.'/storage/framework/caches/*.txt',
    )
    {
        parent::__construct();

    }

    public function actionClear(): void
    {
        array_map("unlink", glob($this->path));
        Response::exitWithPopup('Кэш очищен');
    }
}


