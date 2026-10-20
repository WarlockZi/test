<?php

namespace app\controller;

use app\action\ProductAction;
use app\repository\ProductRepository;
use app\service\Breadcrumbs\NewBreadArray;
use app\service\Product\ProductService;
use app\service\Router\IRequest;
use Exception;
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
     * @throws Exception
     */
    #[NoReturn]
    public function actionIndex(IRequest $request, ProductService $service): void
    {
        if (!$request->slug) response()->redirect('Location:/category');

        $product = $this->repo->index($request->slug)->toArray();
        if (!$product) {
            $service->notFound($product);
        }
//        $similarProducts = $this->actions->similarProducts($request->slug);
        $meta            = $this->actions->setMeta($product);

        $breadcrumbs = (new NewBreadArray(true))->getParents($product['category']);

        view('product.product', compact(
            'meta',
            'breadcrumbs',
            'product',
        ));
    }
}
