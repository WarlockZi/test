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

        protected CategoryRepository        $repo,
        private readonly CategoryAction     $actions,
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

            $this->actions->setCategoryMeta($category);
            $breadcrumbs      = $this->actions->getBreadcrumbs($category->toArray(), false);

            $order = OrderRepository::usersOrder();
            $shippableTable      = $this->actions->shippableTable($category);
            view('category.category',
                compact('category', 'breadcrumbs', 'order', 'shippableTable'),);


        } else {
            $categories = APP->get('rootCategories');
            $this->actions->setCategoriesMeta();

            view('category.categories', compact('categories'));
        }
    }
}
