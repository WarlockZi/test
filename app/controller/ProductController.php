<?php

namespace app\controller;

use app\action\ProductAction;
use app\repository\ProductRepository;
use app\service\Breadcrumbs\BreadcrumbsObj;
use app\service\Breadcrumbs\BreadcrumbsService;
use app\service\Breadcrumbs\BreadcrumbsArray;
use app\service\Cart\CartService;
use app\service\Product\ProductService;
use app\service\Router\IRequest;
use Exception;
use JetBrains\PhpStorm\NoReturn;


class ProductController extends AppController
{
    public function __construct(
        protected ProductRepository $repo,
        private ProductAction       $actions,
        private ProductService       $service,
    )
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[NoReturn]
    public function actionIndex(IRequest $request, CartService $cartService): void
    {
        if (!$request->slug) response()->redirect('Location:/category');

        $product = $this->repo->index($request->slug);
        if (!$product) {
            $this->service->notFound($product);
        }
//        $similarProducts = $this->actions->similarProducts($request->slug);
        $meta            = $this->actions->setMeta($product);
//        $cart =         $cart = $cartService->getProductsInCart()->filter(function ($p)use($product){
//            return $p['1s_id']===$product['1s_id'];
//        })->toArray();
        $cart =         $cart = $cartService->getProductsInCart()->toArray();

        $breadcrumbs = BreadcrumbsService::generate($product['category'], true);

        view('product.product', compact(
            'meta',
            'breadcrumbs',
            'cart',
            'product',
        ));
    }
}
