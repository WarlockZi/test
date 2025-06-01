<?php

namespace app\controller;

use app\service\Logger\ErrorLogger;
use app\service\Zip\ImportFiles;
use app\service\Zip\ZipService;

class ZipController extends AppController
{
    private ZipService $service;
    private ErrorLogger $logger;

    public function __construct()
    {
        $this->service = new ZipService();
        $this->logger  = new ErrorLogger();
    }

    public function actionDownload()
    {
        $files = (new ImportFiles)();

        $this->service
            ->files($files)
            ->path('/storage/app/import/')
            ->zipname('import.zip')
            ->createZip()
            ->download();
        exit;
    }

}