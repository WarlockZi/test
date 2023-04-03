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
      $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, false, true);
    }
    $this->set(compact('product', 'breadcrumbs'));
  }

	public function actionList()
	{
		$items = Product::with('price')
			->take(10)->get();
		$list = ProductView::list($items);
		$this->set(compact('list'));
	}

}
