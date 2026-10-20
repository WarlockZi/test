<?php

namespace app\controller;

use app\action\CategoryAction;
use app\repository\CategoryRepository;
use app\service\Breadcrumbs\NewBreadArray;
use app\service\Category\CategoryService;
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

    #[NoReturn]
    public function actionIndex(IRequest $request, CategoryService $service): void
    {
        if (!$request->slug) {
            $service->notFound($this->actions);
        }
        $category = $this->repo->indexInstore($request->slug);
        if (!$category) {
            $this->actions->similarCategories($request->slug);
        }
        $category    = $category?->toArray() ?: [];
        $breadcrumbs = (new NewBreadArray())->getParents($category);
        view('category.category',
            compact(
                'category',
                'breadcrumbs'
            )
        );
    }
}
