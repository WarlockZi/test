<?php

namespace app\controller;

use app\core\App;
use app\model\User;
use app\view\View;
use app\view\widgets\Accordion\Accordion_sidebar;

class AdminscController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		if (User::can($this->user,'role_employee')){
			View::setJs('admin.js');
			View::setCss('admin.css');
		}
		else{
			header('Location:/auth/profile');
		}


	}

	public function actionProfile()
	{
		View::setJs('auth.js');
		View::setCss('auth.css');
	}

	public
	function actionClearCache()
	{
		$path = ROOT . "/tmp/cache/*.txt";
		array_map("unlink", glob($path));
		exit('Успешно');
	}

	public
	function actionProdtypes()
	{
		$types = App::$app->adminsc->getProd_types();
		$this->set(compact('types'));
	}

	public
	function actionSiteMap()
	{

		$iniCatList = App::$app->category->getInitCategories();
		$this->set(compact('iniCatList'));
	}

	public
	function actionProducts()
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

	public
	function actionIndex()
	{

		View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
	}
}


