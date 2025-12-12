<?php

namespace app\controller\Admin;

use app\decorators\MeasureExecutionTime;
use app\model\User;
use app\service\AuthService\Auth;
use app\service\Logger\SyncLogger;
use app\service\Response;
use app\service\Router\IRequest;
use app\service\Sync\Load\LoadCategories;
use app\service\Sync\Load\LoadPrices;
use app\service\Sync\Load\LoadProducts;
use app\service\Sync\Load\LoadService;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class SyncController extends AdminscController
{
    public function __construct(
//        protected LoadService       $loadService,
        private readonly SyncLogger $logger,
    )
    {
        Auth::setUser(User::where('email', 'vvoronik@yandex.ru')->first());
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function actionInit(): void
    {
        $this->service->requestFrom1s();
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
    #[NoReturn] public function actionLoad(): void
    {
        $this->logger->write('Начата ручная загрузка');
//        $this->service->load();
        if (DEV) {
            Response::exitWithPopup('Все перенесено');
        }
        exit();
    }

    #[NoReturn] public function actionLoadCategories(LoadCategories $loadCategories): void
    {
        $loadCategories->load();
        Response::exitWithPopup('Категории загружены');
    }

    public function actionLoadProducts(LoadProducts $loadProducts): void
    {
        $loadProducts->load();
        if (DEV) {
            Response::exitWithPopup('Products loaded');
        }
    }

    /**
     * @throws Exception
     * @throws \Throwable
     */
    #[MeasureExecutionTime]
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


