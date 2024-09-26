<?php

namespace app\controller;

use app\core\Auth;
use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AppController
{
    protected ProductRepository $repo;
    protected ProductFormView $formView;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ProductRepository();
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
            exit($exception);
        }
        $this->route->setView('product');
        if ($product) {
            $oItems          = OrderRepository::count();
            $breadcrumbs     = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
            $userIsAdmin     = Auth::userIsAdmin();
            $shippablePrices = $this->formView->dopUnitsPrices($product);

            $this->setVars(compact('shippablePrices', 'product', 'breadcrumbs', 'oItems', 'userIsAdmin'));

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
