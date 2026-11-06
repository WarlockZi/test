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

    public function actionLoad(LoadService $service): void
    {
        try {
            $service->checkXMLFuncExist();
            $service->moveFilesLoaded();
            $service->logger->write('**************');

            $service->loadCategories();
            response()->json(['pupup' => 'категории успешно загружены',
                'loaded' => 'category',
                'bottom' => date('Y-m-d H:i:s') . ' - Категории загружены']);

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
        $logs      = StorageLog::getFileContent('sync/success.txt');
        $logLines  = explode("\n", trim($logs));
        view('admin.sync.sync_manual', compact('loadFiles', 'logLines'));
    }

    public function actionCleansuccesslog(StorageLog $storageLogger): void
    {
        $storageLogger->cleanFile('sync/success.txt');
        $logs     = $storageLogger::getFileContent('sync/success.txt');
        $logLines = explode("\n", trim($logs));
        response()->json(['popup' => 'Логи очищены', 'logLines' => $logLines]);
    }

    public function actionDeletefiles(SyncmanualActions $actions, SyncStorage $store): void
    {
        $actions::deleteAllFiles($store);
        $loadFiles = SyncStorage::getUnzippedFiles();
        response()->json($loadFiles);
    }

    public function actionLoadcategories(LoadService $service): void
    {
        try {
//            $service->loadCategories();
            response()->json(['popup' => 'категории успешно загружены',
                'loaded' => 'category',
                'bottom' => date('Y-m-d H:i:s') . ' - Категории загружены']);
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }

    public function actionLoadproducts(LoadService $service): void
    {
        try {
            $service->loadProducts();
            response()->json(['popup' => 'товары успешно загружены',
                'loaded' => 'product',
                'bottom' => date('Y-m-d H:i:s') . ' - Товары загружены']);
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }

    public function actionLoadprices(LoadService $service): void
    {
        try {
            $service->loadPrices();
            response()->withLog(new SyncSuccessLogger)->json([
                'popup' => 'цены успешно загружены',
                'loaded' => 'price',
                'log' => date('Y-m-d H:i:s') . ' - Синхронизация прошла успешно',
                'bottom' => date('Y-m-d H:i:s') . ' - Цены загружены'],
            );
        } catch (Throwable $exception) {
            response()->popup($exception->getMessage());
        }
    }

}


