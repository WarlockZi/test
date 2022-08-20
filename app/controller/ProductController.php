<?php

namespace app\controller;

use app\model\Illuminate\IlluminateModelDecorator;
use app\model\Illuminate\Product;
use app\model\Illuminate\Propertable;
use app\view\Category\CategoryView;
use app\view\Product\ProductView;

class ProductController Extends AppController
{

	protected $model = Product::class;

//	protected $model = 'product';

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$card = ProductView::card($slug);
			$this->set(compact('card'));
		}
	}

	public function actionUpdateOrCreate()
	{
		IlluminateModelDecorator::updateOrCreate(Product::class, $this->ajax);
	}

	public function actionSetProperty()
	{
		if ($id = $this->ajax['id']) {

			$this->exitWithPopup('hurra');
		}
	}

	public function actionList()
	{
		$list = ProductView::listAll();
		$this->set(compact('list'));

	}

	public function actionEdit()
	{
		$id = $this->route['id'];
		$product = ProductView::edit($id);
		$catId = Product::find($id)->category->id;
		$breadcrumbs = CategoryView::breadcrumbs($catId, true);
		$this->set(compact('product', 'breadcrumbs'));
	}


}
