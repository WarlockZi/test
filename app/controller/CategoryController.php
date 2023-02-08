<?php

namespace app\controller;


use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\view\Category\CategoryView;


class CategoryController Extends AppController
{

	public $model = Category::class;
	public $modelName = 'category';

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$accordion = '';
		if (isset($this->route['slug'])) {
			$this->view = 'category';
			$slug = $this->route['slug'];

			$category = Category::where('slug', $slug)
				->with('childrenRecursive')
				->with('parentRecursive')
				->with('products')
				->with('products.mainImages')
				->get()->first();
			$this->set(compact('category'));

			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);
			$this->set(compact('breadcrumbs'));

		} else {
			$categories = Category::where('category_id', 0)
				->with('childrenRecursive')
				->get();
			$this->set(compact('categories'));
			$this->view = 'categories';
		}
		$this->set(compact('accordion'));
	}

}
