<?php

namespace app\controller\Admin;

use app\Actions\SyncActions;
use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\core\Zip;
use app\Repository\SyncRepository;
use app\Services\Logger\ErrorLogger;
use app\Services\Logger\FileLogger;
use app\Storage\StorageDev;
use app\Storage\StorageImport;

class SyncController extends AppController
{
    public $model = xml::class;
    protected $filename;
    protected $importPath;
    protected $actions;
    protected $repo;
    protected Route $route;
    protected $logger = false;
    protected ErrorLogger $errorLogger;
    protected $importFile = false;
    protected $offerFile = false;
    protected $storage;

    public function __construct()
    {
        parent::__construct();

        $this->setStorage();
        $this->logger      = new FileLogger('load.log');
        $this->errorLogger = new ErrorLogger();

        $this->importFile = $this->storage::getFile('import0_1.xml');
        $this->offerFile  = $this->storage::getFile('offers0_1.xml');

        $this->repo    = new SyncRepository($this->importFile, $this->offerFile, $this->logger);
        $this->actions = new SyncActions($this->repo, $this->logger);
    }

    public function setStorage()
    {
        $this->importPath = StorageImport::getPath();
        if ($_ENV['DEV'] == '1') {
            $this->storage = StorageDev::class;
        } else {
            $this->storage = StorageImport::class;
        }
    }

    private function getImportFiles(): array
    {
        if ($_ENV['DEV'] == 1) {
            return [
                'import' => ROOT . '/app/Storage/dev/import0_1.xml',
                'offer' => ROOT . '/app/Storage/dev/offers0_1.xml',
            ];
        } else {
            return [
                'import' => ROOT . '/app/Storage/import/import1_1.xml',
                'offer' => ROOT . '/app/Storage/import/offers1_1.xml',
            ];
        }
    }

    public function actionDownload()
    {
        $files = $this->getImportFiles();
            $this->logger->write("Файлы dddd из 1с загружены");
        $zip   = new Zip($files, 'import.zip');
        $zip->download();
        exit;
    }

    public function actionInit()
    {
        try {
            $this->actions->init();
            $this->logger->write("Файлы из 1с загружены");
        } catch (\Exception $e) {
            $message = PHP_EOL . "---SyncControllerError---" . PHP_EOL . $e . PHP_EOL . $e->getMessage() . PHP_EOL;
            $this->logger->write($message);
            exit('Выгрузка на сайт не удалась. Подробности в load.log');
        }
    }

    public function actionLoad()
    {
        $this->actions->load();
        Response::exitWithPopup('Загружено');
    }

    public function actionRemoveall()
    {
        $this->repo->softTrancate();
        Response::exitWithPopup('Удалено');
    }

    public function actionRemovecategories()
    {
        $this->repo->softRemoveCategories();
    }

    public function actionRemoveproducts()
    {
        $this->repo->softRemoveProducts();
    }

    public function actionRemoveprices()
    {
        $this->repo->removePrices();
    }

    public function actionRemovecategorieswithpopup()
    {
        $this->repo->softRemoveCategories();
        Response::exitWithPopup('Удалены');
    }

    public function actionRemoveproductswithpopup()
    {
        $this->repo->softRemoveProducts();
        Response::exitWithPopup('Удалены');
    }

    public function actionRemovepriceswithpopup()
    {
        $this->repo->removePrices();
        Response::exitWithPopup('Удалены');
    }


    public function actionLoadCategories()
    {
        $this->repo->LoadCategories();

    }

    public function actionLoadProducts()
    {
        $this->repo->LoadProducts();
    }

    public function actionLoadPrices()
    {
        $this->repo->LoadPrices();
    }

    public function actionLoadCategorieswithpopup()
    {
        $this->repo->LoadCategories();
        Response::exitWithPopup('Загружены категории');
    }

    public function actionLoadProductswithpopup()
    {
        $this->repo->LoadProducts();
        Response::exitWithPopup('Загружены товары');
    }

    public function actionLoadPriceswithpopup()
    {
        try {
            $this->repo->LoadPrices();
            Response::exitWithPopup('Загружены цены');
        } catch (\Exception $exception) {
            Response::exitJson($exception);
        }

    }

    public function actionIndex()//init
    {
        $tree = [];
        $this->set(compact('tree'));
    }

    public function actionLogshow()
    {
        if (isset($_POST['param'])) {
            Response::exitJson(['success' => true, 'content' => 'Log' . PHP_EOL . $this->logger->read()]);
        }
    }

    public function actionLogclear()
    {
        $this->logger->clear();
        Response::exitJson(['success' => 'success', 'content' => 'Log' . PHP_EOL . $this->logger->read()]);
    }


    public function actionTruncate()
    {
        $this->repo->trancate();
    }

}


