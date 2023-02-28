<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\view\Category\CategoryView;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\MyTree\Tree;


class CategoryController Extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$categories = Category::with('childrenRecursive')
			->select('id', 'name')
			->get();
//		$categories = Category::all()->toArray();

//		$accordion = Tree::build($categories)
//			->parent('category_id')
//			->model('category')
//			->get();
		$accordion = SelectBuilder::build()
//			->collection($categories)
			->tree($categories, 'childrenRecursive')
//			->('category_id')
//			->model('category')
			->get();

//		$categories = Category::with('childrenRecursive')
//			->select(['id','name'])
//			->get()
//			->toArray();

		$this->set(compact('categories', 'accordion'));

	}

	public function actionEdit()
	{
		$id = $this->route->id;
		$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($id, false, true);
		$category = CategoryView::edit($id);
		$this->set(compact('category', 'breadcrumbs'));
	}

	public function actionList()
	{
		$table = CategoryView::list();

		$this->set(compact('table'));
	}
}
