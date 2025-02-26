<?php

namespace app\controller\Admin;

use app\model\Category;
use app\Repository\CategoryRepository;
use app\Services\Breadcrumbs\AdminBreadcrumbsService;
use app\view\Category\CategoryFormView;

class CategoryController extends AdminscController
{
    public function __construct(
        public string              $model = Category::class,
        private AdminBreadcrumbsService $breadcrumbsService = new AdminBreadcrumbsService(),
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $categoryTree = CategoryFormView::list();
        $this->setVars(compact('categoryTree'));
    }

    public function actionEdit(): void
    {
        $id          = $this->route->id;
        $category    = CategoryRepository::edit($id);
        $breadcrumbs = $this->breadcrumbsService->getCategoryBreadcrumbs($category);
        $category    = CategoryFormView::edit($category);
        $this->setVars(compact('category', 'breadcrumbs'));
    }

    public function actionChangeproperty()
    {
        $this->repo->changeProperty($this->ajax);
    }

    public function actionList()
    {
        $table = CategoryFormView::list();
        $this->setVars(compact('table'));
    }
}
