<?php

namespace app\controller\Admin;

use app\Actions\SyncActions;
use app\controller\AppController;
use app\Services\Logger\FileLogger;

class SyncController extends AppController
{
	public $model = xml::class;
	protected $rawPost;
	protected $filename;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $repo;
	protected $logger = false;

	public function __construct()
	{
		parent::__construct();
		$this->logger = new FileLogger('load.log');
		$this->repo = new SyncActions($this->route, $this->logger);
	}

	public function actionInit()
	{
		try {
			$this->repo->init();
		} catch (\Exception $e) {
			$this->logger->write($e);
			exit('Выгрузка на сайт не удалась. Подробности в load.log');
		}
	}

	public function actionLoad()
	{
		$this->repo->load();
	}

	public function actionRemoveall()
	{
		$this->repo->trancate();
	}

	public function actionRemovecategories()
	{
		$this->repo->removeCategories();
	}

	public function actionRemoveproducts()
	{
		$this->repo->removeProducts();
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


