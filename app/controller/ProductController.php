<?php

namespace app\controller;

use app\action\ProductAction;
use app\repository\ProductRepository;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;


class ProductController extends AppController
{
    public function __construct(
        protected ProductRepository $repo,
        private ProductAction       $actions,
    )
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    #[NoReturn] public function actionIndex(IRequest $request): void
    {
        if (!$request->slug) response()->redirect('Location:/category');

        $product = $this->repo->index($request->slug);
        if (!$product) {
//           $similarProducts = $this->actions->similarProducts($request->slug);
            response()->view('product.notFound',
                compact('product'),
                404);
        }

        $meta         = $this->actions->setMeta($product);
        $orderProduct = $this->actions->orderProduct($product);
        $breadcrumbs  = $this->actions->getBreadcrumbs($product['category'], true);

        $product = $product->toArray();
        view('product.product', compact(
            'meta',
            'breadcrumbs',
            'product',
            'orderProduct',
        ));
    }


}
