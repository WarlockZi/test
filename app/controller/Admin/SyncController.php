<?php

namespace app\controller\Admin;

use app\Actions\SyncActions;
use app\controller\AppController;
use app\Repository\SyncRepository;
use app\Services\Logger\FileLogger;
use app\Storage\StorageDev;
use app\Storage\StorageImport;

class SyncController extends AppController
{
	public $model = xml::class;
	protected $rawPost;
	protected $storage;
	protected $filename;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $actions;
	protected $repo;
	protected $route;
	protected $logger = false;
	protected $importFile = false;
	protected $offerFile = false;

	public function __construct()
	{
		parent::__construct();

		$this->setStorage();
		$this->logger = new FileLogger('load.log');

		$this->importFile = $this->storage::getFile('import0_1.xml');
		$this->offerFile = $this->storage::getFile('offers0_1.xml');

		$this->repo = new SyncRepository($this->route, $this->importFile, $this->offerFile, $this->logger);
		$this->actions = new SyncActions($this->repo);
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

	public function actionInit()
	{
		try {
			$this->actions->init();
		} catch (\Exception $e) {
			$this->logger->write($e);
			exit('Выгрузка на сайт не удалась. Подробности в load.log');
		}
	}

	public function actionLoad()
	{
		$this->actions->load();
	}

	public function actionRemoveall()
	{
		$this->repo->softTrancate();
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


	public function actionIndex()//init
	{
		$tree = [];
		$this->set(compact('tree'));
	}

	public function actionLogshow()
	{
		if (isset($_POST['param'])) {
			$this->exitJson(['success' => true, 'content' => 'Log'.PHP_EOL. $this->logger->read()]);
		}
	}

	public function actionLogclear(){
		$this->logger->clear();
		$this->exitJson(['success' => 'success', 'content' => 'Log'.PHP_EOL.$this->logger->read()]);
	}


	public function actionTruncate()
	{
		$this->repo->trancate();
	}

}


