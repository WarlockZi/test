<?php

namespace app\service\Sync;

use app\service\Fs\FS;
use app\traits\LoggerTrait;


class SyncService
{
    use LoggerTrait;

    protected string $importFile = '/storage/app/sync/import0_1.xml';
    protected string $offerFile = '/storage/app/sync/offers0_1.xml';
    protected string $importPath = '/storage/app/sync/';


    public function __construct()
    {
        $this->importFile = FS::platformSlashes(ROOT . $this->importFile);
        $this->offerFile  = FS::platformSlashes(ROOT . $this->offerFile);
    }

    public function requestFrom1s(): void
    {
        $mode = $_GET['mode'];
//        $type = $_GET['type'];

        switch ($mode) {
            case 'checkauth':
                header('Content-Type: text/plain; charset=utf-8');
                echo "success\n\n\n";
                break;

            case 'file':
                $filename = $_GET['filename'];
                $data     = file_get_contents('php://input');
                file_put_contents($this->importPath . $filename, $data);
                echo "success\n";
                break;

            case 'import':
                $this->load();
                echo "success\n";
                break;

            default:
                header('HTTP/1.0 400 Bad Request');
                echo "Unknown mode";
        }
    }
//    public function requestFrom1s(IRequest $req): void
//    {
//        $this->log("Пришел запрос init из 1с");
//        try {
//            if ($req->params['mode'] === 'checkauth') {
//                $this->checkauth();
//            } elseif ($req->params['mode'] === 'init') {
//                $this->zip();
//            } elseif ($req->params['mode'] === 'file') {
//                $this->file($req->params['filename']);
//            } elseif ($req->params['mode'] === 'import') {
//                $this->log("Файлы из 1с загружены");
//                $this->load();
//                exit('success');
//            }
//        } catch (\Throwable $e) {
//            $this->logError("---SyncControllerError---", $e);
//        }
//    }

//    #[NoReturn] protected function checkauth(): void
//    {
//        $this->log('checkauth');
//        if ($_GET['type'] == 'checkauth') {
//            header("Content-Type: text/plain; charset=utf-8");
//            echo "success\n";
//            echo session_name() . "\n";
//            echo session_id() . "\n";
//            // Или фиксированные значения, как в вашем примере:
//            // echo "success\nnic\n7777\n";
//            exit;
//        }
////        exit("success\ninc\n777777\n55fdsa55");
//    }

//    #[NoReturn] protected function zip(): void
//    {
//        $this->log('init zip');
//        if ($_GET['type'] == 'init') {
//            echo "zip=no\n";
//            echo "file_limit=10_000_000\n";
//            exit;
//        }
////        exit("zip=no\nfile_limit=10_000_000");
//    }

//    protected function file(string $filename): void
//    {
//        try {
//            file_put_contents($this->importPath . $filename, file_get_contents('php://input'));
//            $this->log('file');
//            exit('success');
//        } catch (\Throwable $exception) {
//            $this->log('file load fail. ' . $exception->getMessage());
//            exit('file load fail.');
//        }
//    }

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

