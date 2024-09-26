<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\Services\Logger\FileLogger;
use app\Services\Sync\SyncService;
use app\Services\Sync\TrancateService;

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
    public function actionLoad(): void
    {
        $this->service->load();
        if ($_ENV['DEV'] == 1) {
            Response::exitWithPopup('Все перенесено');
        }
        exit();
    }

    public function actionLoadCategories(): void
    {
        $this->service->LoadCategories();
        if ($_ENV['DEV'] == '1') {
            Response::exitWithPopup('Categories loaded');
        }
    }

    public function actionLoadProducts(): void
    {
        $this->service->LoadProducts();
        if ($_ENV['DEV'] == '1') {
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
        if ($_ENV['DEV'] == '1') {
            Response::exitWithPopup('Categories loaded');
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


