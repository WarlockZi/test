<?php

namespace app\controller\Admin;

use app\formRequest\SyncDownloadZipRequest;
use app\formRequest\SyncRequest;
use app\model\User;
use app\service\AuthService\Auth;
use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Response;
use app\service\Router\IRequest;
use app\service\Storage\SyncStorage;
use app\service\Sync\Load\LoadCategories;
use app\service\Sync\Load\LoadPrices;
use app\service\Sync\Load\LoadProductsBatching;
use app\service\Sync\Load\LoadService;
use app\service\Sync\SyncService;
use app\service\Zip\ZipService;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class SyncController extends AdminscController
{
    public function __construct(
        private readonly SyncLogger  $logger,
        private readonly SyncService $service,
        private readonly ZipService  $zipService,
    )
    {
        Auth::setUser(User::where('email', 'vvoronik@yandex.ru')->first());
        parent::__construct();
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn]
    public function actionLoad(): void
    {
        $this->logger->write('SyncController начал загрузку без архивов');
        $load = new LoadService();
        $load->run();
    }

    /**
     * @throws Exception|Throwable
     */
    #[NoReturn] public function actionInit(SyncRequest $req): void
    {
        error_log('before log');
        $this->logger->write('test start');
        error_log('after log');
        $this->service->requestFrom1s($req);
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function actionUploadZip(SyncDownloadZipRequest $req): void
    {
        $file = $req->validated()['file'];
        $name = $file->getClientOriginalName();
        $path = SyncStorage::getSyncPath();
        $file->move(FS::platformSlashes(ROOT . $path), $name);
        $this->zipService
            ->path($path)
            ->zipname($name)
            ->unzip('unzipped/');
    }

    //remove
    #[NoReturn] public function actionRemoveall(): void
    {
        $this->trancateService->trancateAll();
    }

    #[NoReturn] public function actionTruncate(): void
    {
        $this->trancateService->trancateAll();
    }

    #[NoReturn] public function actionRemovecategories(): void
    {
        $this->trancateService->removeCategories();
    }

    #[NoReturn] public function actionRemoveproducts(): void
    {
        $this->trancateService->removeProducts();
    }

    #[NoReturn] public function actionRemoveprices(): void
    {
        $this->trancateService->removePrices();
    }


    //load


    #[NoReturn] public function actionLoadCategories(LoadCategories $loadCategories): void
    {
        $loadCategories->load();
        Response::exitWithPopup('Категории загружены');
    }

    public function actionLoadProducts(LoadProductsBatching $loadProducts): void
    {
        $loadProducts->load();
        if (DEV) {
            Response::exitWithPopup('Products loaded');
        }
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function actionLoadPrices(LoadPrices $loadPrices): void
    {
        $loadPrices->load();
    }


///// web
    #[NoReturn] public function actionIndex(): void
    {
        view('admin.sync.sync');
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function actionLogshow(IRequest $request): void
    {
        $read    = $this->logger->read();
        $content = $read ? "Log {PHP_EOL} $read" : "Лог пустой";
        response()->json([
            'success' => true,
            'content' => $content,
        ]);

    }

    #[NoReturn] public function actionLogclear(): void
    {
        $this->logger->clear();
        response()->json(['success' => 'success', 'content' => 'Log' . PHP_EOL . $this->logger->read()]);
    }

}


