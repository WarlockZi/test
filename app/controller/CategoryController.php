<?php

namespace app\controller;

use app\repository\CategoryRepository;
use app\service\Breadcrumbs\BreadcrumbsService;
use app\service\Cache\Redis\Cache;
use app\service\Cart\CartService;
use app\service\Category\CategoryService;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;

class CategoryController extends AppController
{
    public function __construct(
        protected CategoryRepository     $repo,
//        private readonly CategoryAction  $actions,
        private readonly CategoryService $service,
    )
    {
        parent::__construct();
    }

    #[NoReturn]
    public function actionIndex(IRequest    $request,
                                CartService $cartService,
    ): void
    {
        $start = microtime(true);
        if (!$request->slug) {
            $this->service->notFound();
        }
        $category = $this->service->index($request->slug);

        if (!$category) {
            $this->service->similarCategories($request->slug);
        }

        $cart = $cartService->getProductsInCart();

        $breadcrumbs = BreadcrumbsService::generate($category);

        $total = microtime(true) - $start;
        view('category.category',
            compact(
                'category',
                'breadcrumbs',
                'cart',
            )
        );
    }
}
