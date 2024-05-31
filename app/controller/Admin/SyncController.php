<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\Services\Logger\FileLogger;
use app\Services\Sync\SyncService;
use JetBrains\PhpStorm\NoReturn;

class SyncController extends AppController
{
   protected SyncService $service;
   protected FileLogger $logger;

   public function __construct()
   {
      parent::__construct();
      $this->service = new SyncService();
      $this->logger  = new FileLogger('import.txt');
   }

   public function actionInit(): void
   {
      $this->service->requestFrom1s();
      exit('done');
   }


   //remove
   public function actionRemoveall(): void
   {
      $this->service->softTrancate();
   }
   public function actionTruncate(): void
   {
      $this->service->trancate();
   }
   public function actionRemovecategories(): void
   {
      $this->service->softRemoveCategories();
   }

   public function actionRemoveproducts(): void
   {
      $this->service->softRemoveProducts();
   }

   public function actionRemoveprices(): void
   {
      $this->service->removePrices();
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


