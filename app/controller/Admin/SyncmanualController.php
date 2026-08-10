<?php

namespace app\controller\Admin;

use app\action\admin\SyncmanualActions;
use app\formRequest\SyncManualDownloadArchiviRequest;
use app\formRequest\SyncManualDownloadFileRequest;
use app\service\Archive\ArchiveService;
use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Logger\SyncSuccessLogger;
use app\service\Storage\StorageLog;
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
            response()->withLog(new SyncSuccessLogger)->popup('Синхронизация прошла успешно');
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
        $loadFiles = SyncStorage::getUnzippedFiles();
        $logs = StorageLog::getFileContent('sync/success.txt');
        $logLines = explode("\n", trim($logs));
        view('admin.sync.sync_manual', compact('loadFiles', 'logLines'));
    }
    public function actionCleansuccesslog(StorageLog $storageLogger): void
    {
        $storageLogger->cleanFile('sync/success.txt');
        $logs = $storageLogger::getFileContent('sync/success.txt');
        $logLines = explode("\n", trim($logs));
        response()->json(['logLines'=>$logLines]);
    }
    public function actionDeletefiles(SyncmanualActions $actions, SyncStorage $store): void
    {
        $actions::deleteAllFiles($store);
        $loadFiles = SyncStorage::getUnzippedFiles();
        response()->json($loadFiles);

    }

    public function actionLoadcategories(): void
    {
        try {
            $load = new LoadService();
            $load->loadCategories();
            response()->popup('категории успешно загружены');
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }
    public function actionLoadprices(): void
    {
        try {
            $load = new LoadService();
            $load->loadPrices();
            response()->withLog(new SyncLogger())->popup('цены и остатки успешно загружены');
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }
    public function actionLoadproducts(): void
    {
        try {
            $load = new LoadService();
            $load->loadProducts();
            response()->withLog(new SyncLogger())->popup('товары успешно загружены');
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }
}


