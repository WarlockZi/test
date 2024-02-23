<?php

namespace app\controller;

use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;


class ShortController extends AppController
{
	protected $model;

	public function actionIndex()
	{
		$short = $this->route->slug;
		if ($short) {

			$this->view = 'product';
			$product = ProductRepository::short($short);
			$oItems = OrderRepository::count();
			if ($product) {
//				$cat = Category::query()->find($product->category_id);
				$cat = $product->category_id;
				$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($cat, true,);
				$this->set(compact('product', 'breadcrumbs', 'oItems'));
				$this->assets->setItemMeta($product);
				$this->assets->setProduct();
				$this->assets->setQuill();
			} else{
				$this->notFound = true;
				$view = $this->getView();
				$this->assets->setMeta('Страница не найдена');
				$this->view = $view->get404();
				http_response_code(404);}
		} else {
			header('Location:/category');
		}
	}

}
