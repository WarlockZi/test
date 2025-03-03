<?php

namespace app\controller;

use app\core\NotFound;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;
use app\Services\Breadcrumbs\BreadcrumbsService;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AppController
{
    public function __construct(
        protected ProductFormView   $formView = new ProductFormView(),
        protected ProductRepository $repo = new ProductRepository(),
        protected BreadcrumbsService $breadcrumbsService = new BreadcrumbsService(),
    )
    {
        parent::__construct();
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
            $order           = OrderRepository::count();
            $breadcrumbs     = $this->breadcrumbsService->getProductBreadcrumbs($product->category);
            $shippablePrices = $this->formView->dopUnitsPrices($product);
            $this->setVars(compact('shippablePrices', 'product', 'breadcrumbs', 'order'));

            $this->assets->setMeta(
                $product->seo_title(),
                $product->seo_description(),
                $product->ownProperties->seo_keywords ?? $product->name);

        } else {
            $this->view = '404';
            http_response_code(404);
            $subslug1        = substr($slug, 0, -5);
            $subslug2        = substr($slug, 0, -27);
            $similarProducts = ProductRepository::similarProducts($subslug1, $subslug2);
            $this->setVars(compact('similarProducts'));
        }
    }
}
