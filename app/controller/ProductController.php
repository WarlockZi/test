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
			$arr = $product->toArray();
			$oItems = OrderRepository::count();
			if ($product) {
				$product->categoryProperties = ProductRepository::preparePropertiesList($product);
				$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category->id, true,);
				$this->set(compact('product', 'breadcrumbs', 'oItems'));
				$this->assets->setItemMeta($product);
				$this->assets->setProduct();
				$this->assets->setQuill();
			} else{
				$this->notFound = true;
				$view = $this->getView('not found');
				$this->assets->setMeta('Страница не найдена');
				$this->view = $view->get404();
				http_response_code(404);}
		} else {
			header('Location:/category');
		}
	}

}
