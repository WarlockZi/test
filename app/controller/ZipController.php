<?php

namespace app\controller;

use app\service\Logger\ErrorLogger;
use app\service\Zip\ImportFiles;
use app\service\Zip\ZipService;

class ZipController extends AppController
{

    public function __construct(
        private ZipService  $service,
        private ErrorLogger $logger,

    )
    {
        parent::__construct();
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