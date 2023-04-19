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

		$this->repo = new SyncRepository();
	}

	public function actionIncread()
	{
		$this->repo->read();
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

	public function actionInit()
	{
		$this->repo->init();
	}

	public function actionPart()//init
	{
		$this->repo->part();
	}

	public function actionIndex()//init
	{
		$tree = [];
		$this->set(compact('tree'));
//		$this->repo->part();
	}

	public function actionPartload()//load
	{
		$this->repo->partload();
	}

	public function actionParseImages()
	{

	}



	public function actionLoad()
	{
		$this->repo->import();
	}

}


