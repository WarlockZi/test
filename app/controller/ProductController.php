<?php

namespace app\controller;

use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\View;


class ProductController Extends AppController
{
	public function actionIndex()
	{
		$this->view='product';
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$product = ProductRepository::getProduct('slug',$slug);
			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category,false,);
			$this->set(compact('product', 'breadcrumbs'));
		}
		View::setItemMeta($product);
	}

}
