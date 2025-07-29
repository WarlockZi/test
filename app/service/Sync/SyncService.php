<?php

namespace app\service\Sync;


use app\service\Fs\FS;
use app\service\Logger\SyncLogger;
use app\service\Router\IRequest;
use app\traits\LoggerTrait;
use JetBrains\PhpStorm\NoReturn;


class SyncService
{
    use LoggerTrait;

    protected string $importFile = '/storage/app/sync/import0_1.xml';
    protected string $offerFile = '/storage/app/sync/offers0_1.xml';
    protected string $importPath = '/storage/app/sync/';


    public function __construct(
        protected SyncLogger $logger = new SyncLogger(),
    )
    {
        $this->importFile = FS::platformSlashes(ROOT . $this->importFile);
        $this->offerFile  = FS::platformSlashes(ROOT . $this->offerFile);
    }

    public function requestFrom1s(IRequest $route): void
    {
        $this->logDate();
        $this->log("Пришел запрос init из 1с");
        try {
            if ($route->params['mode'] === 'checkauth') {
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

    #[NoReturn] protected function zip(): void
    {
        $this->log('init zip');
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

    private function importFilesExist(): void
    {
        if (!is_readable($this->importFile))
            throw new \Exception($this->importFile . 'import file not found');

        if (!is_readable($this->offerFile))
            throw new \Exception($this->offerFile . 'import file not found');
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
        $this->importFilesExist();
        try {
//            $this->trancateService->softTrancate();
            $this->LoadCategories();
            $this->LoadProducts();
            $this->LoadPrices();
            $this->log('Load успех' . PHP_EOL);
        } catch (\Throwable $e) {
            $this->logError("--- Ошибка load ", $e);
        }
    }


}

