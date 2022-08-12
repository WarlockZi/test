<?php

namespace app\controller;

use app\core\App;
use app\model\Product;
use \app\model\Prop;
use app\view\View;

class CatalogController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);

	}

	public function actionIndex()
	{

		$cats_id = Category::getInitCategories();
		View::setMeta('Каталог спецодежды', 'Каталог спецодежды', 'Каталог спецодежды');
		$this->set(compact('cats_id'));
	}

	public function actionProduct($product)
	{

		header('Cache-Control: private, max-age=8400');
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
		$this->view = 'product';

		$breadcrumbs = Product::getBreadcrumbs($product, $product['parents'], 'product');

		View::setMeta($product['title'], $product['description'], $product['keywords']);
		$this->set(compact('breadcrumbs', 'product'));

		View::setCss('vitex.css');
	}


	public function actionCategory($category)
	{
		$breadcrumbs = App::$app->product->getBreadcrumbs($category, $category['parents'], 'category');
		$canonical = $category['alias'];
		View::setMeta($category['title'], $category['keywords'], $category['description']);
		$this->set(compact('breadcrumbs', 'category', 'canonical'));
		View::setCss('vitex.css');
	}

}
