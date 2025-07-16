<?php

namespace app\controller;

use app\action\CategoryAction;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\Router\IRequest;
use JetBrains\PhpStorm\NoReturn;

class CategoryController extends AppController
{
    public function __construct(
        protected CategoryRepository    $repo,
        private readonly CategoryAction $actions,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionIndex(IRequest $request): void
    {
        if ($request->slug) {
            $category = $this->repo->indexInstore($request->slug);

            if (!$category) {
                $similarCategories = $this->actions->similarCategories($request->slug);
                view('category.notFound',
                    compact('category', 'similarCategories'),
                    404);
            }

            $meta        = $this->actions->setCategoryMeta($category);
            $breadcrumbs = $this->actions->getBreadcrumbs($category, false);

            $order          = OrderRepository::usersOrder();
            $shippableTable = $this->actions->shippableTable($category);
            view('category.category',
                compact(
                    'category',
                    'meta',
                    'breadcrumbs',
                    'order',
                    'shippableTable',
                )
            );


        } else {
            $meta = $this->actions->setCategoriesMeta();
            view('category.categories', compact('meta'));
        }
    }
}
