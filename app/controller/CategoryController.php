<?php

namespace app\controller;


use app\model\Category;
use app\view\Category\CategoryView;
use app\view\Category\CountryView;


class CategoryController Extends AppController
{

	public $model = \app\model\Category::class;
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
			$alias = $this->route['slug'];

			$category = Category::where('alias', $alias)
				->with('childrenRecursive')
				->with('parentRecursive')
				->with('products')
				->with('products.mainImages')
				->get()->first();
			$this->set(compact('category'));

			$breadcrumbs = CategoryView::breadcrumbs($category->id, false, false);
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

//
//	public function actionIndex()
//	{
//		$slug = $this->route['slug'];
//
//		$categories = Category::where('slug',$slug)
//			->with('children')
//			->first()
//			->toArray();
//
//		$accordion = Tree::build($categories)
//			->parent('category_id')
//			->model('category')
//			->get();
//
//		$this->set(compact('categories'));
//		$this->set(compact('accordion'));
//	}


	public function actionEdit()
	{
		$id = $this->route['id'];
		$breadcrumbs = CountryView::breadcrumbs($id);
		$category = CountryView::edit($id);
		$this->set(compact('category', 'breadcrumbs'));
	}

}
