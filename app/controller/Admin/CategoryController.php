<?php

namespace app\controller\Admin;

use app\action\admin\CategoryAction;
use app\model\Category;
use app\repository\CategoryRepository;
use app\service\Router\IRequest;
use app\view\Category\CategoryFormView;

class CategoryController extends AdminscController
{
    public function __construct(
        private readonly CategoryAction $actions,
        public string                   $model = Category::class,
    )
    {
        parent::__construct();
    }

    public function actionIndex(): void
    {
        $categoryTree = CategoryFormView::list();
        $this->setVars(compact('categoryTree'));
    }

    public function actionEdit(IRequest $route): void
    {
        $category     = CategoryRepository::edit($route->id);
        $breadcrumbs  = $this->actions->getBreadcrumbs($category->toArray(), false);
//        $categoryView = $this->actions->edit($category);
        $catItem = CategoryFormView::edit($category);
        view('admin.category.edit',
            compact('category',
                'breadcrumbs',
                'catItem'
            ));
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
