<?php

namespace app\controller;

use app\Services\Logger\ErrorLogger;
use app\Services\ZipService\ImportFiles;
use app\Services\ZipService\ZipService;

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
        foreach ($files as $file) {
            $this->logger->write($file);
        }

        $this->service
            ->files($files)
            ->path('/app/Storage/import/')
            ->zipname('import.zip')
            ->download();
        exit;
    }

}