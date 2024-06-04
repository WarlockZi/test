<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\Repository\ReportRepository;
use app\view\Product\Admin\ProductFormView;
use app\view\Report\Admin\ReportView;


class ReportController extends AppController
{
private ReportRepository $repo;
private ReportView $formView;
	public function __construct()
	{
		parent::__construct();
        $this->repo = new ReportRepository();
        $this->formView = new ReportView();
	}

	public function actionProductsnoimgInstore()
	{
		$this->view = 'productsnoimginstore';
		$p = $this->repo->noImgInStore();
		$productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок в наличии');
		$this->set(compact('productList'));
	}

	public function actionProductsnoimgNotinstore()
	{
		$this->view = 'productswithoutimg';
		$p = $this->repo->noImgNotInStore();
		$productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок без наличия');
		$this->set(compact('productList'));
	}

	public function actionProductsNoMinUnit()
	{
		$this->view = 'productsnominunit';
		$products = $this->repo->noMinimumUnit();
		$productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}

	public function actionProductsNoShippable()
	{
        $this->route->setView('productsnoimg');
		$products = $this->repo->noDopUnit();
		$productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}
//	public function actionProductsnosipppable()
//	{
//        $products = $this->repo->haveDopUnit();
//        $productList = $this->formView->haveDopUnit($products, 'Товары имеющие доп единицы');
//		$this->set(compact('productList'));
//	}
    public function actionTrashed()
    {
        $products = $this->repo->trashed();
        $productList = $this->formView->haveDopUnit($products, 'Товары имеющие доп единицы');
        $this->set(compact('productList'));
    }
}


