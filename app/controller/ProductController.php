<?php

namespace app\controller;

use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\View;


class ProductController extends AppController
{
  public function actionIndex()
  {
    if (isset($this->route['slug'])) {
      $this->view = 'product';
      $slug = $this->route['slug'];
      $product = ProductRepository::getProduct('slug', $slug);
      $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category, false,);
      $this->set(compact('product', 'breadcrumbs'));
      View::setItemMeta($product);
    } else {
      header('Location:/category');
    }
  }

}
