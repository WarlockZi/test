<?php


namespace app\Actions;


use app\controller\AppController;
use app\core\Error;
use app\core\Route;
use app\Repository\SyncRepository;
use app\Services\Logger\ErrorLogger;
use app\Storage\StorageDev;
use app\Storage\StorageImport;

class SyncActions extends AppController
{
    protected $importPath;
    protected $storage;
    protected $importFile;
    protected $offerFile;
    protected $viewPath = ROOT . '/app/view/Sync/Admin/';
    protected $logger;
    protected ErrorLogger $errorLogger;
    protected $repo;
    protected Route $route;

    public function __construct(SyncRepository $repo, $logger)
    {
        $this->importPath = StorageImport::getPath();
        $this->storage = new StorageImport;
        $this->repo        = $repo;
        $this->logger      = $logger;
        $this->errorLogger = new ErrorLogger();

        $this->importFile = $this->importPath.'import0_1.xml';
        $this->offerFile  = $this->importPath.'offers0_1.xml';
    }

    /**
     * @throws \Exception
     */
    public function init(Route $route)
    {
        $this->route = $route;
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
        } catch (\Throwable $exception) {
            $this->errorLogger->write($exception->getMessage());
        }

    }

    private function importFilesExist()
    {
        if (!is_readable($this->importFile)) {
            $this->logger->write('Отсутстует файл importFile');
            return false;
        }
        if (!is_readable($this->offerFile)) {
            $this->logger->write('Отсутстует файл offerFile');
            return false;
        }
        return true;
    }

    public function load()
    {
        try {
            if (!$this->importFilesExist()) exit('Отсутстуют импорт файлы');

            $this->repo->softTrancate();

            $this->repo->LoadCategories();
            $this->repo->LoadProducts();
            $this->repo->LoadPrices();

        } catch (\Exception $e) {
            exit(PHP_EOL . '---Ошибка загрузки: SyncActions---' . PHP_EOL . $e->getMessage() . PHP_EOL . $e);
        }
    }

    protected function checkauth()
    {
        $this->logReqest('checkauth');
        exit("success\ninc\n777777\n55fdsa55");
    }

    protected function zip()
    {
        $this->logReqest('init');
        exit("zip=no\nfile_limit=10000000");
    }

    protected function file()
    {
        $filename = $this->route->params['filename'];
        file_put_contents($this->importPath . $filename, file_get_contents('php://input'));

        $this->logReqest('file');
        exit('success');
    }

    protected function logReqest($func)
    {
        $text = date("Y-m-d H:i:s") . "--{$func}" . PHP_EOL;

        if (isset($this->route->params['filename'])) {
            $text .= 'filename - ' . $filename = $this->route->params['filename'] . PHP_EOL;
            $text .= $this->importPath . $filename;
        }
        $this->logger->write($text);
    }

}
