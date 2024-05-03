<?php


namespace app\Repository;


use app\Actions\XMLParser\LoadCategories;
use app\Actions\XMLParser\LoadPrices;
use app\Actions\XMLParser\LoadProducts;
use app\core\Route;
use app\model\Category;
use app\model\Price;
use app\model\Product;
use Carbon\Carbon;

class SyncRepository
{
	protected $importFile;
	protected $offerFile;
	protected $logger;
//	protected $route;
	public function __construct($importFile, $offerFile, $logger)
	{
//		$this->route = $route;
		$this->importFile = $importFile;
		$this->logger = $logger;
		$this->offerFile = $offerFile;
	}

	public function LoadCategories()
	{
		new LoadCategories($this->importFile, $this->logger);
	}

	public function LoadProducts()
		{
		new LoadProducts($this->importFile, $this->logger);
	}

	public function LoadPrices()
	{
		new LoadPrices($this->offerFile, $this->logger);
	}

	public function softTrancate()
	{
		$this->removeCategories();
		$this->softRemoveProducts();
		$this->removePrices();

	}

	public function trancate()
	{
		$this->softTrancate();
//		$this->removeCategories();
//		$this->removeProducts();
//		$this->removePrices();
	}

	protected function softDelete($model)
	{
		$model->update(['deleted_at'=>Carbon::today()]);
	}

	public function softRemoveProducts()
	{
		foreach (Product::all() as $model) {
			$this->softDelete($model);
		}
	}

	public function softRemoveCategories()
	{
		foreach (Category::all() as $model) {
			$this->softDelete($model);
		}
	}

	public function softRemovePrices()
	{
		Price::truncate();
	}


	private function removeProducts()
	{
		Product::truncate();
	}

	private function removeCategories()
	{
		Category::truncate();
	}

	public function removePrices()
	{
		Price::truncate();
	}
}