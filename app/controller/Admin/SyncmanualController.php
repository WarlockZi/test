<?php

namespace app\controller\Admin;

use app\formRequest\SyncManualDownloadArchiviRequest;
use app\formRequest\SyncManualDownloadFileRequest;
use app\service\Archive\ArchiveService;
use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Sync\Load\LoadService;
use app\service\Sync\Load\SyncLog;
use app\service\Sync\SyncService;
use app\service\Zip\ZipService;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class SyncmanualController extends AdminscController
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
    public function actionUploadextract(SyncManualDownloadArchiviRequest $req): void
    {
        $file = $req->safe()->only('file')['file'];
        $name = $file->getClientOriginalName();
        $path = env('SYNC_PATH');
        $file->move(FS::platformSlashes(ROOT . $path), $name);

        (new ArchiveService())->archiveFilePath(ROOT . $path . $name)
            ->toPath(ROOT . $path . 'unzipped/')
            ->extract();
    }

    public function actionLoad()
    {
        $loadService = new LoadService();
        try {
            $loadService->run();
            response()->popup('Успешно загружено');
        } catch (Throwable $exception) {
            response()->popup('Ошибка загрузки ' . $exception->getMessage());
        }
    }

    public function actionUploadoffer(SyncManualDownloadFileRequest $req): void
    {
        response()->popup('Запрос пришел');

        $file = $req->safe()->only('file')['file'];
        $name = $file->getClientOriginalName();
        if ($name !== env('SYNC_OFFER_FILE')) {
            response()->popup('Это не offer file');
        }
        $path = env('SYNC_PATH') . 'unzipped/';
        $file->move(FS::platformSlashes(ROOT . $path), $name);
        response()->json(['file' => $name, 'popup' => 'file загружен']);
    }

    public function actionUploadimport(SyncManualDownloadFileRequest $req): void
    {
        response()->popup('Запрос пришел');
        $file = $req->safe()->only('file')['file'];
        $name = $file->getClientOriginalName();
        if ($name !== env('SYNC_IMPORT_FILE')) {
            response()->popup('Это не import file');
        }
        $path = env('SYNC_PATH') . 'unzipped/';
        $file->move(FS::platformSlashes(ROOT . $path), $name);
        response()->json(['file' => $name, 'popup' => 'file загружен']);
    }

    #[NoReturn]
    public function actionIndex(): void
    {
        $path        = env('SYNC_PATH');
        $unzippedDir = FS::platformSlashes(ROOT . $path . 'unzipped/');
        $allfiles    = scandir($unzippedDir);
        $files       = array_filter($allfiles, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'xml';
        });
        $xmlFiles    = [];

        foreach ($files as $file) {
            if ($file === env('SYNC_IMPORT_FILE')) {
                $xmlFiles['import'] = $file;
            } elseif ($file === env('SYNC_OFFER_FILE')) {
                $xmlFiles['offer'] = $file;
            }
        }

        view('admin.sync.sync_manual', compact('xmlFiles'));
    }

}


