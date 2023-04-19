<?php

namespace app\controller;

use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;


class ProductController extends AppController
{
	protected $model;

	public function actionIndex()
	{
		$slug = $this->route->slug;
		if ($slug) {

			$this->view = 'product';
			$product = ProductRepository::main($slug);
			$oItems = OrderRepository::count();
			$product->categoryProperties = ProductRepository::preparePropertiesList($product);

			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category->id, true,);
			$this->set(compact('product', 'breadcrumbs', 'oItems'));
			$this->assets->setItemMeta($product);

		} else {
			header('Location:/category');
		}
	}

}
