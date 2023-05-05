<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryFormView;
use app\view\Category\CategoryView;


class CategoryController extends AppController
{

  public $model = Category::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function actionIndex()
  {
    $categories = CategoryRepository::treeAll();
    $accordion = '';
    if ($categories->count()) {
      $accordion = CategoryFormView::indexTree($categories) ;
    }
    $this->set(compact('accordion'));
  }

  public function actionEdit()
  {
    $id = $this->route->id;
    $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($id, false, true);
    $category = CategoryFormView::edit($id);
    $this->set(compact('category', 'breadcrumbs'));
  }

  public function actionList()
  {
    $table = CategoryFormView::list();

    $this->set(compact('table'));
  }
}
