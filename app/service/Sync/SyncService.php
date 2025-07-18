<?php

namespace app\service\Sync;

use app\service\Logger\SyncLogger;
use app\service\Response;
use app\service\Router\Request;
use app\service\Storage\app\SyncStorage;
use JetBrains\PhpStorm\NoReturn;

class SyncService
{
    protected string $importFile = '';
    protected string $offerFile = '';

    public function __construct(
        protected SyncLogger      $logger,
        protected SyncStorage     $storage,
        protected TrancateService $trancateService,
    )
    {
        $this->importFile = $this->storage::getFile('import0_1.xml');
        $this->offerFile  = $this->storage::getFile('offers0_1.xml');
//        $this->loadProducts = new LoadProducts($this->importFile);
    }

    public function requestFrom1s(Request $route): void
    {
        try {
            if ($route->params['mode'] === 'checkauth') {
                $this->logDate();
                $this->log("Пришел запрос init из 1с");
                $this->checkauth();
            } elseif ($route->params['mode'] === 'init') {
                $this->zip();
            } elseif ($route->params['mode'] === 'file') {
                $this->file($route->params['filename']);
            } elseif ($route->params['mode'] === 'import') {
                $this->log("Файлы из 1с загружены");
                $this->load();
                exit('success');
            }
        } catch (\Throwable $e) {
            $this->logError("---SyncControllerError---", $e);
        }
    }

    #[NoReturn] protected function checkauth(): void
    {
        $this->log('checkauth');
        exit("success\ninc\n777777\n55fdsa55");
    }

    protected function zip(): void
    {
        $this->log('init');
        exit("zip=no\nfile_limit=10_000_000");
    }

    protected function file(string $filename): void
    {
        try {
            file_put_contents($this->importPath . $filename, file_get_contents('php://input'));
            $this->log('file');
            exit('success');
        } catch (\Throwable $exception) {
            $this->log('file load fail. ' . $exception->getMessage());
            exit('file load fail.');
        }
    }

    private function importFilesExist(): bool
    {
        if (!is_readable($this->importFile)) {
            $this->logger->write('Отсутстует файл importFile');
            if (!is_readable($this->offerFile)) {
                $this->logger->write('Отсутстует файл offerFile');
                return false;
            }
        }
        return true;
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
            if ($this->importFilesExist()) {
//            $this->trancateService->softTrancate();
                $this->LoadCategories();
                $this->LoadProducts();
                $this->LoadPrices();
                $this->log('Load успех' . PHP_EOL);
            } else {
                throw new \Exception('import file not found');
            }
        } catch (\Throwable $e) {
            $this->logError("--- Ошибка load ", $e);
        }
    }

///log

    protected function logDate(): void
    {
        $this->log(date("Y-m-d H:i:s"));
    }

    protected function logError(string $msg, $e): void
    {
        $this->logDate();
        $this->logger->write('- error -' . $msg . PHP_EOL . $e);
        if (DEV) {
            Response::exitWithPopup($msg);
        }
        exit();
    }

    protected function log(string $msg): void
    {
        $this->logger->write($msg);

    }
}

