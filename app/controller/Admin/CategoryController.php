<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\view\Category\CategoryView;
use app\view\components\MyTree\Tree;


class CategoryController Extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$categories = Category::all()->toArray();

		$accordion = Tree::build($categories)
			->parent('category_id')
			->model('category')
			->get();

		$this->set(compact('categories'));
		$this->set(compact('accordion'));
	}

	public function actionEdit()
	{
		$id = $this->route->id;
		$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($id,false, true);
		$category = CategoryView::edit($id);
		$this->set(compact('category', 'breadcrumbs'));
	}

	public function actionList()
	{
		$table = CategoryView::list();

		$this->set(compact('table'));
	}
}
