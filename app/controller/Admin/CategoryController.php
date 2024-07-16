<?php

namespace app\controller\Admin;

use app\Actions\CategoryAction;
use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryArrayFormView;
use app\view\Category\CategoryFormView;

class CategoryController extends AppController
{
    public $model = Category::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $categories = CategoryRepository::treeAll();
        $accordion  = '';
        if ($categories->count()) {
//            $categoryTree = CategoryRepository::treeAll();
            $categoryTree= CategoryFormView::indexTree($categories);
        }
        $this->set(compact('categoryTree'));
    }

    public function actionEdit()
    {
        $id           = $this->route->id;
        $breadcrumbs  = BreadcrumbsRepository::getCategoryBreadcrumbs($id, false, true);
        $category     = CategoryArrayFormView::edit($id);
        $this->set(compact('category', 'breadcrumbs'));
    }
    public function actionCreate(): void
    {
        $this->view = 'edit';
        $category = Category::create();
        $category     = CategoryArrayFormView::edit($category->id);
        $this->set(compact('category'));
    }
    public function actionChangeproperty()
    {
        $this->repo->changeProperty($this->ajax);
    }

    public function actionList()
    {
        $table = CategoryFormView::list();
        $this->set(compact('table'));
    }
}
