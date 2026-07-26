<?php

namespace app\controller\Admin;

use app\formRequest\SyncManualDownloadArchiviRequest;
use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Rar\RarService;
use app\service\Storage\SyncStorage;
use app\service\Sync\SyncService;
use app\service\Zip\ZipService;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class SyncManualController extends AdminscController
{
    public function __construct(
        private readonly SyncLogger  $logger,
        private readonly SyncService $service,
        private readonly ZipService  $zipService,
    )
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[NoReturn]
    public function actionUploadZip(SyncManualDownloadArchiviRequest $req): void
    {
        $file = $req->safe()->only('file')['file'];
        $name = $file->getClientOriginalName();
        $path = SyncStorage::getPath();
        $file->move(FS::platformSlashes(ROOT . $path), $name);

        if ($file->getClientOriginalExtension() === 'zip') {
            $this->zipService
                ->path($path)
                ->zipname($name)
                ->unzip('unzipped/');
        } elseif ($file->getClientOriginalExtension() === 'rar') {
            $f =  1;
            (new RarService())->archiveFilePath($path)
                ->toPath($path)
                ->extract();
        };


    }

///// web
    #[NoReturn]
    public function actionIndex(): void
    {
        view('admin.sync.sync_manual');
    }

}


