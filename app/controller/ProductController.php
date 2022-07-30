<?php

namespace app\controller;

use app\model\Product;
use app\view\Product\ProductView;
use app\view\View;

class ProductController Extends AppController
{

	protected $modelName = Product::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->layout = 'vitex';
//		View::setCss('admin.css');
//		View::setJs('admin.js');

	}

	public function actionIndex()
	{
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$model = new $this->modelName;
			$items = $model::where('slug','=', $slug)->get();
			$list = ProductView::listItems($items);

		} else {
			$list = ProductView::listAll();

		}


		$this->set(compact('list'));
	}

	public function actionEdit()
	{
		$id = $this->route['id'];
		$item = ProductView::edit($id);
		$this->set(compact('item'));
	}



}
