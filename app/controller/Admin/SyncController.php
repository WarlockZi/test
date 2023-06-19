<?php

namespace app\controller\Admin;

use app\Actions\SyncActions;
use app\controller\AppController;
use app\Repository\SyncRepository;
use app\Services\XMLParser\LoadProductsOffer;

class SyncController extends AppController
{
	public $model = xml::class;
	protected $rawPost;
	protected $filename;
	protected $viewPath = ROOT . '/app/view/Sync/Admin/';
	protected $repo;

	public function __construct()
	{
		parent::__construct();
		$this->repo = new SyncActions($this->route);
	}

	public function actionPart()//init
	{
		$this->repo->part();
	}

	public function actionPartload()//load
	{
		$this->repo->partload();
	}

	public function actionInit()
	{
		$this->repo->init();
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


	public function actionLoad()
	{
		$this->repo->import();
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
		$this->repo->logshow();
	}

	public function actionLogclear()
	{
		$this->repo->logclear();
	}



	public function actionTruncate()
	{
		$this->repo->trancate();
	}


	public function actionParseImages()
	{

	}
}


