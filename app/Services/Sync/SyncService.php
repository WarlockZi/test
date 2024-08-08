<?php

namespace app\Services\Sync;

use app\core\Response;
use app\core\Route;
use app\Services\Logger\FileLogger;
use app\Storage\StorageImport;

class SyncService
{
    protected string $importPath = '';
    protected string $importFile = '';
    protected string $offerFile = '';

    public function __construct(
        protected FileLogger      $logger = new FileLogger('import.txt'),
        protected StorageImport   $storage = new StorageImport,
        protected TrancateService $trancateService = new TrancateService,
    )
    {

        $this->importPath = $this->storage->getStoragePath();
        $this->importFile = $this->storage::getFile('import0_1.xml');
        $this->offerFile  = $this->storage::getFile('offers0_1.xml');
//        $this->loadProducts = new LoadProducts($this->importFile);
    }

    public function requestFrom1s(Route $route): void
    {
        try {
            if ($route->params['mode'] === 'checkauth') {
                $this->logReqest("Пришел запрос init из 1с");
                $this->checkauth();
            } elseif ($route->params['mode'] === 'init') {
                $this->zip();
            } elseif ($route->params['mode'] === 'file') {
                $this->file($route->params['filename']);
            } elseif ($route->params['mode'] === 'import') {
                $this->logReqest("Файлы из 1с загружены");
                exit('success');
            }
        } catch (\Throwable $e) {
            $this->logError("---SyncControllerError---", $e);
        }
    }

    protected function checkauth(): void
    {
        $this->logReqest('checkauth');
        exit("success\ninc\n777777\n55fdsa55");
    }

    protected function zip(): void
    {
        $this->logReqest('init');
        exit("zip=no\nfile_limit=10000000");
    }

    protected function file($filename): void
    {
        file_put_contents($this->importPath . $filename, file_get_contents('php://input'));
        $this->logReqest('file');
        exit('success');
    }

    private function importFilesExist(): void
    {
        if (!is_readable($this->importFile)) {
            $this->logger->write('Отсутстует файл importFile');
            if (!is_readable($this->offerFile)) {
                $this->logger->write('Отсутстует файл offerFile');
            }
        }
    }


//load
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
        try {
            $this->importFilesExist();
//            $this->trancateService->softTrancate();
            $this->LoadCategories();
            $this->LoadProducts();
            $this->LoadPrices();
            $this->log('Load успех' . PHP_EOL);

        } catch (\Throwable $e) {
            $this->logError("--- Ошибка load ", $e);
        }
    }

///log
    protected function logReqest($func): void
    {
        $this->logDate();
        $this->logger->write("func {$func}" . PHP_EOL);
    }

    protected function logDate(): void
    {
        $date = date("Y-m-d H:i:s");
        $this->logger->write($date);
    }

    protected function logError(string $msg, $e): void
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
//        $this->logDate();
        $this->logger->write($msg);

    }
}

