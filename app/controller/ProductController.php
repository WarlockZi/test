<?php

namespace app\controller;

use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\View;


class ProductController extends AppController
{
	protected $model;

	public function actionIndex()
	{
		if (isset($this->route['slug'])) {
			$this->view = 'product';
			$slug = $this->route['slug'];
			$product = ProductRepository::getProduct('slug', $slug);
			$product->categoryProperties = ProductRepository::preparePropertiesList($product);

			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category->id, false,);
			$this->set(compact('product', 'breadcrumbs'));
			View::setItemMeta($product);
		} else {
			header('Location:/category');
		}
	}

}
