<?php

namespace app\controller;

use app\service\Fs\FS;
use app\service\Zip\ZipException;
use app\service\Zip\ZipService;
use JetBrains\PhpStorm\NoReturn;

class ZipController extends AppController
{
private array $unzippedFiles =  [];
    public function __construct(
        private readonly ZipService $service,
    )
    {
        parent::__construct();
        $this->unzippedFiles = [
            'import' => FS::platformSlashes(ROOT . '/storage/app/import/'.env("SYNC_IMPORT_FILE")),
            'offer' => FS::platformSlashes(ROOT . '/storage/app/import/'.env('SYNC_OFFER_FILE')),
        ];
    }

    /**
     * @throws ZipException
     */
    #[NoReturn] public function actionDownload(): void
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