<?php

namespace app\Services\Sync;

use app\core\Response;
use app\core\Route;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\Services\Logger\FileLogger;
use app\Storage\Storage;
use app\Storage\StorageImport;
use Carbon\Carbon;
use JetBrains\PhpStorm\NoReturn;

class SyncService
{
   protected string $filename;
   protected string $importPath = '';
   protected string $importFile = '';
   protected string $offerFile = '';
   protected Route $route;
   protected Storage $storage;
   protected FileLogger $logger;

   public function __construct()
   {
      $this->logger = new FileLogger('import');

      $this->storage    = new StorageImport;
      $this->importPath = $this->storage->getStoragePath();
      $this->importFile = $this->storage::getFile('import0_1.xml');
      $this->offerFile  = $this->storage::getFile('offers0_1.xml');

   }

   public function requestFrom1s(): void
   {
      $this->logReqest("Пришел запрос init из 1с");
      $this->logReqest($this->route);
      try {
         if ($this->route->params['mode'] === 'checkauth') {
            $this->checkauth();
         } elseif ($this->route->params['mode'] === 'init') {
            $this->zip();
         } elseif ($this->route->params['mode'] === 'file') {
            $this->file();
         } elseif ($this->route->params['mode'] === 'import') {
            exit('success');
         }

         $this->logReqest("Файлы из 1с загружены");
      } catch (\Throwable $e) {
         $this->logError("---SyncControllerError---", $e);
      }
   }

   public function softTrancate(): void
   {
      $this->removeCategories();
      $this->softRemoveProducts();
      $this->removePrices();
   }

   public function trancate(): void
   {
      $this->softTrancate();
//		$this->removeCategories();
//		$this->removeProducts();
//		$this->removePrices();
   }


   public function softRemoveProducts(): void
   {
      foreach (Product::all() as $model) {
         $this->softDelete($model);
      }
      $this->log('--- products  soft deleted ---');
   }

   public function softRemoveCategories(): void
   {
      foreach (Category::all() as $model) {
         $this->softDelete($model);
      }
      $this->log('--- category  soft deleted ---');
   }

   protected function softDelete($model): void
   {
      $model->update(['deleted_at' => Carbon::today()]);
   }

   private function removeProducts(): void
   {
      Product::truncate();
      $this->log('--- products  deleted ---');
   }

   private function removeCategories(): void
   {
      Category::truncate();
      $this->log('--- category  deleted ---');
   }

   public function softRemovePrices(): void
   {
      Price::truncate();
      $this->log('--- price deleted ---');
   }


   public function removePrices(): void
   {
      Price::truncate();
      $this->log('--- price  deleted ---');
   }

   public function LoadCategories(): void
   {
      new LoadCategories($this->importFile);
      $this->log('--- category  loaded ---');
   }

   public function LoadProducts(): void
   {
      new LoadProducts($this->importFile);
      $this->log('--- products loaded  ---');
   }

   public function LoadPrices(): void
   {
      new LoadPrices($this->offerFile);
      $this->log('--- price     loaded ---');
   }

   public function load(): void
   {
//      $this->log('Load start');
      try {
         $this->importFilesExist();

         $this->softTrancate();

         $this->LoadCategories();
         $this->LoadProducts();
         $this->LoadPrices();
         $this->log('Load успех' . PHP_EOL);

      } catch (\Throwable $e) {
         $this->logError("--- Ошибка load ", $e);
      }
   }

   protected function tc(callable $fn): void
   {
      try {
         $fn();
      } catch (\Throwable $exception) {
         $this->logReqest(debug_backtrace()[1]["function"]);
      }
   }

   #[NoReturn] protected function checkauth(): void
   {
      $this->logReqest('checkauth');
      exit("success\ninc\n777777\n55fdsa55");
   }

   #[NoReturn] protected function zip(): void
   {
      $this->logReqest('init');
      exit("zip=no\nfile_limit=10000000");
   }

   #[NoReturn] protected function file(): void
   {
      $filename = $this->route->params['filename'];
      file_put_contents($this->importPath . $filename, file_get_contents('php://input'));

      $this->logReqest('file');
      exit('success');
   }

   private function importFilesExist(): bool
   {
      if (!is_readable($this->importFile)) {
         $this->logger->write('Отсутстует файл importFile');
         if (!is_readable($this->offerFile)) {
            $this->logger->write('Отсутстует файл offerFile');
         }
         return false;
      }
      return true;
   }

///log
   protected function logReqest($func): void
   {
      $this->logDate();
      $this->logger->write("func {$func} started" . PHP_EOL);
   }

   protected function logDate(): void
   {
      $date = date("F j, Y, g:i a");
      $this->logger->write($date . PHP_EOL);
   }

   #[NoReturn] protected function logError(string $msg, $e): void
   {
      $this->logDate();
      $this->logger->write('- error -' . $msg . PHP_EOL . $e);
      if ($_ENV['DEV'] == '1') {
         Response::exitWithPopup($msg);
      }
      exit();
   }

   protected function log(string $msg): void
   {
      $this->logDate();
      $this->logger->write($msg);
      if ($_ENV['DEV'] == '1') {
         Response::exitWithPopup($msg);
      }
   }
}