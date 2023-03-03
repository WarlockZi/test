<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryView;
use app\view\components\Builders\SelectBuilder\OptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\TreeABuilder;
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;


class CategoryController Extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$categories = CategoryRepository::treeAll();

		$accordion =
			TreeABuilder::build(
				$categories,'children_recursive',2)

				->href('/adminsc/category/edit/')
				->get();

//		$accordion = SelectBuilder::build(
//			TreeOptionsBuilder::build(
//				$categories,'children_recursive',2)
//				->initialOption()
//				->get()
//		)->get();

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
