<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\Product\ProductView;


class ProductController extends AppController
{
  public $model = Product::class;

  public function actionEdit()
  {
    $id = $this->route->id;
    $prod = ProductRepository::edit($id);
    if ($prod) {
      $product = ProductView::edit($prod);
      $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
    }
    $this->set(compact('product', 'breadcrumbs'));
  }

	public function actionList()
	{
//		$pagination = ProductView::pagination();
//		$req = $this->ajax;
//		if ($req){
//		}

		$items = ProductRepository::list();
		$list = ProductView::list($items);
		$this->set(compact('list'));
	}

}
