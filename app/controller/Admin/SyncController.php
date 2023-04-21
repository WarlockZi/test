<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\FS;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use app\model\Unit;
use app\Repository\SyncRepository;
use app\Services\XMLParser\LoadCategories;
use app\Services\XMLParser\LoadPrices;
use app\Services\XMLParser\LoadProducts;
use app\Services\XMLParser\LoadProductsOffer;
use app\Storage\StorageImport;
use app\Storage\StorageLog;
use app\Storage\StorageXml;

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
		$this->repo = new SyncRepository($this->route);
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



	public function actionParseImages()
	{

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

	public function actionTruncate()
	{
		$this->repo->trancate();
	}

	public function actionLoad()
	{
		$this->repo->import();
	}


	public function actionIndex()//init
	{
		$tree = [];
		$this->set(compact('tree'));
	}


	public function actionIncread()
	{
		list($content, $button) = $this->repo->read();
		$this->set(compact('content', 'button'));
	}

	public function actionIncClear()
	{
		$this->repo->incClear();
	}

	public function actionIncTruncate()
	{
		$this->repo->truncate();
		$count = Category::count();
		$this->exitJson(['success' => 'success', 'content' => 'Удалены категории, товары, цены Количество кат - ' . $count]);
	}

}


