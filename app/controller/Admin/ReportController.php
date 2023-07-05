<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\view\Product\ProductFormView;

class ReportController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionProductswithoutimg()
	{
		$p = ProductRepository::hasNoImg();
		$productList = ProductFormView::hasNoImgList($p);
		$this->set(compact('productList'));
	}

}


