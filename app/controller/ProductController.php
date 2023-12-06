<?php

namespace app\controller;

use app\model\Category;
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
