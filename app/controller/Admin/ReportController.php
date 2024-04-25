<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\view\Product\Admin\ProductFormView;


class ReportController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionProductsnoimgInstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::noImgInStore();
		$productList = ProductFormView::noImgNoInstoreList($p, 'Товары без картинок в наличии');
		$this->set(compact('productList'));
	}

	public function actionProductsnoimgNotinstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::noImgNotInStore();
		$productList = ProductFormView::noImgNoInstoreList($p, 'Товары без картинок без наличия');
		$this->set(compact('productList'));
	}

	public function actionProductsnominimumunit()
	{
		$this->view = 'productswithoutimg';
		$products = ProductRepository::noMinimumUnit();
		$productList = ProductFormView::noMinUnitList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}

	public function actionProductsnodopunit()
	{
        $this->view = 'productsnoimg';
		$productList = ProductRepository::noDopUnit();
		$this->set(compact('productList'));
	}
	public function actionProductshavedopunit()
	{
        $this->view = 'productsnoimg';
		$productList = ProductRepository::haveDopUnit();
		$this->set(compact('productList'));
	}

}


