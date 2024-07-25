<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\Services\Logger\FileLogger;
use app\Services\Sync\SyncService;
use app\Services\Sync\TrancateService;
use JetBrains\PhpStorm\NoReturn;

class SyncController extends AppController
{
    public function __construct(
        protected SyncService     $service = new SyncService(),
        protected TrancateService $trancateService = new TrancateService(),
        protected FileLogger      $logger = new FileLogger('import.txt'),
    )
    {
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
    #[NoReturn] public function actionLoad(): void
    {
        $this->service->load();
        exit();
    }

    public function actionLoadCategories(): void
    {
        $this->service->LoadCategories();
    }

    public function actionLoadProducts(): void
    {
        $this->service->LoadProducts();
    }

    public function actionLoadPrices(): void
    {
        $this->service->LoadPrices();
    }


///// web
    public function actionIndex(): void//init
    {
        $tree = [];
        $this->set(compact('tree'));
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


