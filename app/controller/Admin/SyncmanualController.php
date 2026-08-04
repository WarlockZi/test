<?php

namespace app\controller\Admin;

use app\action\admin\SyncmanualActions;
use app\formRequest\SyncManualDownloadArchiviRequest;
use app\formRequest\SyncManualDownloadFileRequest;
use app\service\Archive\ArchiveService;
use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadService;
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

    public function actionLoad(LoadService $loadService)
    {
        try {
            $loadService->run();
            response()->popup('Успешно загружено');
        } catch (Throwable $exception) {
            response()->popup('Ошибка загрузки ' . $exception->getMessage());
        }
    }


    public function actionUploadoffer(SyncManualDownloadFileRequest $files, SyncmanualActions $actions)
    {
        $actions::unploadFile($files->file('file'));
    }

    public function actionUploadimport(SyncManualDownloadFileRequest $files, SyncmanualActions $actions): void
    {
        $actions::unploadFile($files->file('file'));
    }

    #[NoReturn]
    public function actionIndex(): void
    {
        $loadFiles['import']    = SyncStorage::getUnzippedFile(env('SYNC_IMPORT_FILE'));
        $loadFiles['offer']    = SyncStorage::getUnzippedFile(env('SYNC_OFFER_FILE') );

        view('admin.sync.sync_manual', compact('loadFiles'));
    }

}


