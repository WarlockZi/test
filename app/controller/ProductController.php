<?php

namespace app\controller;

use app\core\NotFound;
use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;
use app\Services\Seo\ProductSeoService;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AppController
{
    protected ProductRepository $repo;
    protected ProductFormView $formView;

    public function __construct()
    {
        parent::__construct();
        $this->repo     = new ProductRepository();
        $this->formView = new ProductFormView();
    }

    public function actionIndex(): void
    {
        if (!$slug = $this->route->slug) header('Location:/category');

        try {
            $product = $this->repo->main($slug);
        } catch (\Throwable $exception) {
            NotFound::NotFound($slug);
            $product = null;
        }
        $this->view = 'product';
        if ($product) {
            $order          = OrderRepository::count();
            $breadcrumbs     = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
            $shippablePrices = $this->formView->dopUnitsPrices($product);
            $this->setVars(compact('shippablePrices', 'product', 'breadcrumbs', 'order'));

            $title    = $product->seo_title();
            $desc     = $product->seo_description();
            $keywords = $product->ownProperties->seo_keywords ?? $product->name;
            $this->assets->setMeta($title, $desc, $keywords);

        } else {
            $this->view = '404';
            http_response_code(404);
            $subslug1 = substr($slug, 0, -5);
            $subslug2 = substr($slug, 0, -27);
            $similarProducts = ProductRepository::similarProducts($subslug1, $subslug2);
            $this->setVars(compact( 'similarProducts'));
        }
    }
}
