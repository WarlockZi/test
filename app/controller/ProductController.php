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
		$slug = $this->route->slug;
		if ($slug) {
			$this->view = 'product';
			$product = ProductRepository::getProduct('slug', $slug);
			$product->categoryProperties = ProductRepository::preparePropertiesList($product);

			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category->id, false,);
			$this->set(compact('product', 'breadcrumbs'));
			$this->assets->setItemMeta($product);
		} else {
			header('Location:/category');
		}
	}

}
