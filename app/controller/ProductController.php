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
        if (!$slug) {
            header('Location:/category');
        }

        $product = ProductRepository::main($slug);
        if ($product) {
            $this->view  = 'product';
            $oItems      = OrderRepository::count();
            $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
            $this->set(compact('product', 'breadcrumbs', 'oItems'));
            $this->assets->setItemMeta($product);
            $this->assets->setProduct();
            $this->assets->setQuill();
        } else {
            $this->notFound = true;
            $view           = $this->getView();
            $this->assets->setMeta('Страница не найдена');
            $this->view = $view->get404();
            http_response_code(404);
        }
    }
}
