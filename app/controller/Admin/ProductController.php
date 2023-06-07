<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\controller\AppController;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\FormViews\ProductFormView;


class ProductController extends AppController
{
	public $model = Product::class;

	public function actionEdit()
	{
		$id = $this->route->id;
		$prod = ProductRepository::edit($id);
		$arr = $prod->toArray();
		if ($prod) {
			$product = ProductFormView::edit($prod);
			$breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
		}
		$this->set(compact('product', 'breadcrumbs'));
		$this->assets->setProduct();
		$this->assets->setQuill();
	}

	public function actionList()
	{
		$items = ProductRepository::list();
		$list = ProductFormView::list($items);
		$this->set(compact('list'));
	}

	public function actionAttach()
	{
		ProductAction::attach($this->ajax);
	}
}
