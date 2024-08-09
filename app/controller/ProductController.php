<?php

namespace app\controller;

use app\core\Auth;
use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;


class ProductController extends AppController
{
    protected ProductRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ProductRepository();
    }

    public function actionIndex(): void
    {
        $slug = $this->route->slug;
        if (!$slug) {
            header('Location:/category');
        }

        $product = $this->repo->main($slug);
        $this->route->setView('product');
        if ($product) {
            exit($slug.'  -  '.var_dump($product->toArray()));
            $oItems = OrderRepository::count();
            $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
            $userIsAdmin = Auth::isAdmin();
            $shippablePrices = $this->repo->dopUnitsPrices($product);

            $this->set(compact('shippablePrices', 'product', 'breadcrumbs', 'oItems', 'userIsAdmin'));

            $title    = $product->ownProperties->seo_title ?? $product->name;
            $desc     = $product->ownProperties->seo_description ?? $product->name;
            $keywords = $product->ownProperties->seo_keywords ?? $product->name;
            $this->assets->setMeta($title, $desc, $keywords);

            $this->assets->setProduct();
//         $this->assets->setQuill();http://vitexopt.ru/short/9zL6pN6fL2wL
        } else {
            $this->assets->setMeta('Страница не найдена');
            http_response_code(404);
        }
    }
}
