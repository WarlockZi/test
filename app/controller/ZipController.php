<?php

namespace app\controller;

use app\service\Fs\FS;
use app\service\Zip\ZipService;

class ZipController extends AppController
{
private array $unzippedFiles =  [];
    public function __construct(
        private readonly ZipService $service,
    )
    {
        parent::__construct();
        $this->unzippedFiles = [
            'import' => FS::platformSlashes(ROOT . '/storage/app/import/import0_1.xml'),
            'offer' => FS::platformSlashes(ROOT . '/storage/app/import/offers0_1.xml'),
        ];
    }

    public function actionDownload()
    {
        $this->service
            ->files($this->unzippedFiles)
            ->path('/storage/app/import/')
            ->zipname('import.zip')
            ->createZip()
            ->download();
        exit;
    }

}