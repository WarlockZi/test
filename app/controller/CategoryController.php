<?php

namespace app\controller;

use app\action\CategoryAction;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\Response;
use app\service\Router\IRequest;
use app\view\components\cardPanel\CardPanel;

class CategoryController extends AppController
{

    public function __construct(
        protected CardPanel                 $categoryView,
        protected CategoryRepository        $repo,
        private readonly CategoryAction     $actions,
    )
    {
        parent::__construct();
    }

    public function actionIndex(IRequest $request): void
    {
        if ($request->slug) {
            $category = $this->repo->indexInstore($request->slug);
            if (!$category) {
                $similarCategories = $this->actions->similarCategories($request->slug);
                Response::view('category.notFound',
                    compact('category', 'similarCategories'),
                    404);
            }

            $breadcrumbs      = $this->actions->getBreadcrumbs($category->toArray(), false);
            $unsubmittedOrder = OrderRepository::unsubmittedUsersOrder();
            $this->actions->setCategoryMeta($category);

            view('category.category',
                compact('category', 'breadcrumbs', 'unsubmittedOrder'));


        } else {
            $categories = APP->get('rootCategories');
            $this->actions->setCategoriesMeta();

            Response::view('category.index', compact('categories'));
        }
    }
}
