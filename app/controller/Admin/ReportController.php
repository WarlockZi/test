<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\Repository\ReportRepository;
use app\view\Product\Admin\ProductFormView;


class ReportController extends AppController
{
private ReportRepository $repo;
	public function __construct()
	{
		parent::__construct();
        $this->repo = new ReportRepository();
	}

	public function actionProductsnoimgInstore()
	{
		$this->view = 'productswithoutimg';
		$p = $this->repo->noImgInStore();
		$productList = ProductFormView::noImgNoInstoreList($p, 'Товары без картинок в наличии');
		$this->set(compact('productList'));
	}

	public function actionProductsnoimgNotinstore()
	{
		$this->view = 'productswithoutimg';
		$p = $this->repo->noImgNotInStore();
		$productList = ProductFormView::noImgNoInstoreList($p, 'Товары без картинок без наличия');
		$this->set(compact('productList'));
	}

	public function actionProductsnominimumunit()
	{
		$this->view = 'productswithoutimg';
		$products = $this->repo->noMinimumUnit();
		$productList = ProductFormView::noMinUnitList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}

	public function actionProductsnodopunit()
	{
        $this->view = 'productsnoimg';
		$productList = $this->repo->noDopUnit();
		$this->set(compact('productList'));
	}
	public function actionProductshavedopunit()
	{
        $products = $this->repo->haveDopUnit();
        $productList = ProductFormView::haveDopUnit($products, 'Товары имеющие доп единицы');
		$this->set(compact('productList'));
	}
    public function actionTrashed()
    {
        $products = $this->repo->trashed();
        $productList = ProductFormView::haveDopUnit($products, 'Товары имеющие доп единицы');
        $this->set(compact('productList'));
    }
}


