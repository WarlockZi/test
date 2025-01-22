<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\core\Response;
use app\model\User;
use app\Services\Logger\FileLogger;
use app\Services\Sync\SyncService;
use app\Services\Sync\TrancateService;
use Illuminate\Support\Carbon;
use Throwable;

class SyncController extends AdminscController
{
    public function __construct(
        protected SyncService     $service = new SyncService(),
        protected TrancateService $trancateService = new TrancateService(),
        protected FileLogger      $logger = new FileLogger('import.txt'),
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
        if (DEV) {
            Response::exitWithPopup('Categories loaded');
        }
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
        try {
            $this->service->LoadPrices();
        } catch (Throwable $exception) {
            $exc = $exception;
            exit($exc);
        }
        if (DEV) {
            Response::exitWithPopup('Prices, units,  loaded');
        }

    }


///// web
    public function actionIndex(): void//init
    {
        $tree = [];
        $this->setVars(compact('tree'));
    }

    public function actionLogshow(): void
    {
        if (isset($_POST['param'])) {
            Response::exitJson([
                'success' => true,
                'content' => 'Log' . PHP_EOL . $this->logger->read()
            ]);
        }
    }

    public function actionLogclear(): void
    {
        $this->logger->clear();
        Response::exitJson(['success' => 'success', 'content' => 'Log' . PHP_EOL . $this->logger->read()]);
    }

}


