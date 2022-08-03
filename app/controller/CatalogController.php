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


	public function actionProducts()
	{

		$fName = $fAct = $fArt = 0;
		$params = explode('&', $_SERVER['QUERY_STRING'], 2);
		if (count($params) > 1) {
			$QSA = urldecode($params[1]);
			$pattern = '/&?page=[0-9]+&?/';
			$replacement = '';
			$QSA = preg_replace($pattern, $replacement, $QSA);
		}

		if (isset($_GET['name'])) {
			$fName = $_GET['name'];
		}
		if (isset($_GET['act'])) {
			$fAct = $_GET['act'];
		}
		if (isset($_GET['art'])) {
			$fArt = $_GET['art'];
		}
		$perpage = 15;
		// Получение текущей страницы
		if (isset($_GET['page'])) {
			$page = (int)$_GET['page'];
			if ($page < 1)
				$page = 1;
		} else {
			$page = 1;
		}
// начальная позиция для запроса
		$start_pos = ($page - 1) * $perpage;
		if ($fName || $fAct || !$fAct || $fArt) {
			$where = App::$app->adminsc->where($fName, $fAct, $fArt);
			$params = App::$app->adminsc->params($fName, $fAct, $fArt);
			$sql = "SELECT * FROM products $where LIMIT $start_pos,$perpage";
			$products = App::$app->product->findBySql($sql, $params);
			$sql = "SELECT * FROM products $where";
			$productsCnt = count(App::$app->product->findBySql($sql, $params));
			$cnt_pages = ceil($productsCnt / $perpage);
			if (!$cnt_pages)
				$cnt_pages = 1;

			if ($page > $cnt_pages)
				$page = $cnt_pages;
		} else {

			$sql = "SELECT * FROM products LIMIT $start_pos,$perpage";
			$products = App::$app->product->findBySql($sql);
			$productsCnt = (INT)App::$app->product->productsCnt();
		}
		$cnt_pages = ceil($productsCnt / $perpage);
		if (!$cnt_pages)
			$cnt_pages = 1;

		if ($page > $cnt_pages)
//         $page = $cnt_pages;
			$this->vars['js'][] = $this->getJSCSS('.js');

		$this->set(compact('products', 'productsCnt', 'cnt_pages', 'QSA'));
	}

	public function actionCategory($category)
	{

		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = User::findOneWhere($_SESSION['id']);
			$this->set(compact('user'));
		}

		$breadcrumbs = App::$app->product->getBreadcrumbs($category, $category['parents'], 'category');
		$canonical = $category['alias'];
		View::setMeta($category['title'], $category['keywords'], $category['description']);
		$this->set(compact('breadcrumbs', 'category', 'canonical'));
		View::setCss('vitex.css');
	}

}
