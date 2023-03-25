<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\Category\CategoryView;
use app\view\components\Builders\SelectBuilder\TreeABuilder;
use function PHPSTORM_META\type;


class CategoryController Extends AppController
{

	public $model = Category::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$categories = CategoryRepository::treeAll();
//		$categories = CategoryRepository::all();

		$accordion = CategoryView::indexTree($categories);

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
