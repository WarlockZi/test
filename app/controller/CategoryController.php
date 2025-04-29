<?php

namespace app\controller;

use app\model\Order;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\AuthService\Auth;
use app\service\Breadcrumbs\BreadcrumbsService;
use app\service\Router\IRequest;
use app\view\components\cardPanel\CardPanel;

class CategoryController extends AppController
{

    public function __construct(
        protected CardPanel                 $categoryView = new CardPanel(),
        protected CategoryRepository        $repo = new CategoryRepository(),
        private readonly BreadcrumbsService $breadcrumbsService = new BreadcrumbsService(),
    )
    {
        parent::__construct();
    }

    public function actionIndex(IRequest $request): void
    {
        if ($request->slug) {
            $category = $this->repo->indexInstore($request->slug);

            if ($category) {
                $breadcrumbs = $this->breadcrumbsService->getCategoryBreadcrumbs($category, false, false);
                $unsubmittedOrder = OrderRepository::unsubmittedUsersOrder();
                $this->assets->seo->setCategoryMeta($category);
                $this->render(
                    'category.category',
                    compact('category', 'breadcrumbs', 'unsubmittedOrder')
                );
            }

        } else {
            $categories = APP->get('rootCategories');
            $this->assets->seo->setCategoriesMeta();

            $this->render('category.index', compact('categories'));
        }
    }
}
