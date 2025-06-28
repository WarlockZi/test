<?php

namespace app\controller\Admin;

use app\action\admin\CategoryAction;
use app\model\Category;
use app\repository\CategoryRepository;
use app\service\Router\IRequest;
use app\view\Category\CategoryFormView;
use JetBrains\PhpStorm\NoReturn;

class CategoryController extends AdminscController
{
    public function __construct(
        private readonly CategoryAction $actions,
        public string                   $model = Category::class,
    )
    {
       parent::__construct();
    }

    #[NoReturn] public function actionIndex(): void
    {
        $categoryTree = CategoryFormView::list();
        view('admin.category.index', ['categoryTree' => $categoryTree]);
    }

    #[NoReturn] public function actionEdit(IRequest $route): void
    {
        $category     = CategoryRepository::edit($route->id);
        $breadcrumbs  = $this->actions->getBreadcrumbs($category, false);
        $catItem = CategoryFormView::edit($category);
        view('admin.category.edit',
            compact('category',
                'breadcrumbs',
                'catItem'
            ));
    }

    public function actionChangeproperty(IRequest $request): void
    {
        $this->actions->changeProperty($request);
    }
}