<?php

namespace app\controller;


use app\model\Category;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\Repository\ProductRepository;


class CategoryController Extends AppController
{

	protected $model = Category::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{

		if ($this->route->slug) {
			$this->view = 'category';

			$slug = $this->route->slug;
			$category = CategoryRepository::index($slug);
			if ($category) {
				$category->products->filters = ProductRepository::getFilters();
				$breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);
				$this->set(compact('breadcrumbs', 'category'));
				$this->assets->setItemMeta($category);
			}
		} else {
			$this->view = 'categories';

			$categories = CategoryRepository::indexNoSlug();

			$this->set(compact('categories'));
		}
	}
}
