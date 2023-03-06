<?php

namespace app\controller;


use app\core\Route;
use app\model\Category;
use app\Repository\BreadcrumbsRepository;


class CategoryController Extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$accordion = '';
		if ($this->route->slug) {
			$this->view = 'category';
			$slug = $this->route->slug;

			$category = Category::where('slug', $slug)
				->with('childrenRecursive')
				->with('parentRecursive')
				->with('products')
				->with('products.mainImages')
				->get()->first();

			$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);

			$this->set(compact('breadcrumbs','category'));

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
