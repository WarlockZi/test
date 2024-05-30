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

  public function actionIndex():void
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
    $category = CategoryArrayFormView::edit($id);
    $this->set(compact('category', 'breadcrumbs'));
  }
	public function actionChangeproperty()
	{
		CategoryAction::changeProperty($this->ajax);
	}

  public function actionList()
  {
    $table = CategoryFormView::list();
    $this->set(compact('table'));
  }
}
