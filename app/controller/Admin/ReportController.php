<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Product;
use app\Repository\ProductRepository;
use app\view\Product\ProductFormView;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;

class ReportController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionProductswithoutimgInstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::hasNoImgInStore();
		$productList = ProductFormView::hasNoImgList($p, 'Товары без картинок в наличии');
		$this->set(compact('productList'));
	}

	public function actionProductswithoutimgNotinstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::hasNoImgNotInStore();
		$productList = ProductFormView::hasNoImgList($p, 'Товары без картинок без наличия');
		$this->set(compact('productList'));
	}

	public function actionProductsnominimumunit()
	{
		$this->view = 'productswithoutimg';
		$products = ProductRepository::noMinimumUnit();
		$productList = ProductFormView::hasNoImgList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}

	public function actionProductshaveonlybaseunit()
	{
		$productList = ProductRepository::haveOnlyBaseUnit();
		$this->set(compact('productList'));
	}
}


