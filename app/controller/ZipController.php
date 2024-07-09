<?php

namespace app\controller;

use app\Services\ZipService\ImportFiles;
use app\Services\ZipService\ZipService;

class ZipController extends AppController
{
    private ZipService $service;

    public function __construct()
    {
        $this->service = new ZipService();
    }

    public function actionDownload()
    {
        $files = (new ImportFiles)();
        $this->service
            ->files($files)
            ->path('/app/Storage/import/')
            ->zipname('import.zip')
            ->download();
        exit;
    }

}