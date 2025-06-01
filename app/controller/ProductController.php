<?php

namespace app\controller;

use app\action\ProductAction;
use app\repository\ProductRepository;
use app\service\Meta\MetaService;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;


class ProductController extends AppController
{
    public function __construct(
        protected ProductRepository $repo,
        private MetaService         $meta,
        private ProductAction       $actions,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(IRequest $request): void
    {
        if (!$request->slug) response()->redirect('Location:/category');

        $product = $this->repo->main($request->slug);
        if (!$product) {
            $similarCategories = $this->actions->similarProducts($request->slug);
            view('category.notFound',
                compact('product', 'similarCategories'),
                404);
        }
        $this->actions->setMeta($product);
        $meta        = $this->meta;
        $breadcrumbs = $this->actions->getBreadcrumbs($product->category->toArray(), true);
//        $order = OrderRepository::usersOrder();
        $shippableTable = $this->actions->shippableUnits('product', $product);
//        $shippableTable = $this->actions->shippableUnits('product', $product);

        view('product.product', compact(
            'meta',
            'breadcrumbs',
            'product',
            'shippableTable',
        ));
    }
}
