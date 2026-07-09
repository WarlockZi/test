<?php

namespace app\controller;

use app\action\ProductAction;
use app\repository\OrderRepository;
use app\repository\ProductRepository;
use app\service\Breadcrumbs\NewBreadArray;
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
        $order = $this->actions->orderProduct($product)?->toArray();

        $product = $product->toArray();
        $breadcrumbs  = (new NewBreadArray(true))->getParents($product['category']);

        view('product.product', compact(
            'meta',
            'breadcrumbs',
            'product',
            'order',
        ));
    }


}
