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
        $slug = $this->route->slug;
        if (!$slug) {
            header('Location:/category');
        }

        try {
            $product = $this->repo->main($slug);
        } catch (\Throwable $exception) {
            NotFound::NotFound($slug);
            $product = null;
        }
        $this->view = 'product';
        if ($product) {
            $oItems          = OrderRepository::count();
            $breadcrumbs     = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
            $shippablePrices = $this->formView->dopUnitsPrices($product);

            $this->setVars(compact('shippablePrices', 'product', 'breadcrumbs', 'oItems'));

            $title    = ProductSeoService::title($product);
            $desc     = ProductSeoService::desc($product);
            $keywords = $product->ownProperties->seo_keywords ?? $product->name;
            $this->assets->setMeta($title, $desc, $keywords);

//            $this->assets->setProduct();
//         $this->assets->setQuill();http://vitexopt.ru/short/9zL6pN6fL2wL
        } else {
            $this->view = '404';
            http_response_code(404);
//            Response::notFound();
//            $this->assets->setMeta('Страница не найдена');
//            http_response_code(404);
        }

    }


}
