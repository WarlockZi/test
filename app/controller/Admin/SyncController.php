<?php

namespace app\controller\Admin;

use app\Actions\SyncActions;
use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\Repository\SyncRepository;
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
    protected $importFile = false;
    protected $offerFile = false;
    protected $storage;

    public function __construct()
    {
        parent::__construct();

        $this->setStorage();
        $this->logger = new FileLogger('load.log');

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

    public function actionDownload()
    {
        $zip =  new \ZipArchive();
        $tmp_file = 'assets/myzip.zip';
        if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
            $zip->addFile(ROOT . '/app/Storage/import/import0_1.xml', 'import0_1.xml');
            $zip->addFile(ROOT . '/app/Storage/import/offers0_1.xml', 'offers0_1.xml');
            $zip->close();
//            echo 'Archive created!';
            header('Content-disposition: attachment; filename=files.zip');
            header('Content-type: application/zip');
            readfile($tmp_file);
        } else {
            echo 'Failed!';
        }


//        $files = [
//            'import' => ROOT . '/app/Storage/import/import0_1.xml',
//            'offer' => ROOT . '/app/Storage/import/offers0_1.xml',
//        ];

//        foreach ($files as $file) {
//            if (is_readable($file)) {
//                header('Pragma: public');
//                header('Expires: 0');
//                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//                header('Cache-Control: private', false); // required for certain browsers
//                header('Content-Type: application/pdf');
//
//                header('Content-Disposition: attachment; filename="' . basename($file) . '";');
//                header('Content-Transfer-Encoding: binary');
//                header('Content-Length: ' . filesize($file));
//
//                readfile($file);
//            }
//        }
//
//
//        exit;
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


