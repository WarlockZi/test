<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryFormView;

class CategoryController extends AdminscController
{
    public string $model = Category::class;

    public function __construct()
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
        $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($id, false, true);
        $category    = CategoryRepository::edit($id);
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
