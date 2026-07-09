<?php

namespace app\controller;

use app\action\CategoryAction;
use app\model\Category;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\Breadcrumbs\NewBreadArray;
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
                $this->actions->noCategory($request->slug);
            }

            $order = OrderRepository::usersOrder(currentUser: true, submitted: true)?->toArray();

            $category = $category?->toArray() ?: [];
            $breadcrumbs = (new NewBreadArray())->getParents($category);
            view('category.category',
                compact(
                    'category',
                    'order',
                    'breadcrumbs'
                )
            );

        } else {
            $categories = APP->get('rootCategories');
            $meta       = $this->actions->setCategoriesMeta();
            view('category.categories', compact('meta', 'categories'));
        }
    }

}
