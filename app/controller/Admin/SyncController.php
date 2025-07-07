<?php

namespace app\controller\Admin;

use app\model\User;
use app\service\AuthService\Auth;
use app\service\Logger\FileLogger;
use app\service\Response;
use app\service\Router\IRequest;
use app\service\Sync\SyncService;
use app\service\Sync\TrancateService;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\NoReturn;

class SyncController extends AdminscController
{
    public function __construct(
        protected SyncService     $service,
        protected TrancateService $trancateService,
        protected FileLogger      $logger,
    )
    {
        Auth::setUser(User::where('email', 'vvoronik@yandex.ru')->first());
        parent::__construct();
    }

    public function actionInit(): void
    {
        $this->service->requestFrom1s($this->route);
        exit('done');
    }


    //remove
    public function actionRemoveall(): void
    {
        $this->trancateService->softTrancate();
    }

    public function actionTruncate(): void
    {
        $this->trancateService->trancate();
    }

    public function actionRemovecategories(): void
    {
        $this->trancateService->softRemoveCategories();
    }

    public function actionRemoveproducts(): void
    {
        $this->trancateService->softRemoveProducts();
    }

    public function actionRemoveprices(): void
    {
        $this->trancateService->removePrices();
    }


    //load
    public function actionLoad(): void
    {
        $this->logger->write(Carbon::now());
        $this->logger->write('Начата ручная загрузка');
        $this->service->load();
        if (DEV) {
            Response::exitWithPopup('Все перенесено');
        }
        exit();
    }

    public function actionLoadCategories(): void
    {
        $this->service->LoadCategories();
        Response::exitWithPopup('Categories loaded');
    }

    public function actionLoadProducts(): void
    {
        $this->service->LoadProducts();
        if (DEV) {
            Response::exitWithPopup('Products loaded');
        }
    }

    public function actionLoadPrices(): void
    {
        $this->service->LoadPrices();

        if (DEV) {
            Response::exitWithPopup('Prices, units,  loaded');
        }
    }


///// web
    #[NoReturn] public function actionIndex(): void
    {
        view('admin.sync.sync');
    }

    public function actionLogshow(IRequest $request): void
    {
        $read    = $this->logger->read();
        $content = $read ? "Log {PHP_EOL} $read" : "Лог пустой";
        response()->json([
            'success' => true,
            'content' => $content,
        ]);

    }

    public function actionLogclear(): void
    {
        $this->logger->clear();
        response()->json(['success' => 'success', 'content' => 'Log' . PHP_EOL . $this->logger->read()]);
    }

}


