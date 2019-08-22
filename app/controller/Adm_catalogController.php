<?php

namespace app\controller;

use app\core\App;
use app\controller\AppController;
use app\model\Catalog;
use app\model\Prop;
use app\core\Base\View;

class Adm_catalogController extends AdminscController {

   public function __construct($route) {
      parent::__construct($route);

      if ($this->isAjax()) {
         if (isset($_POST['param'])) {
            $arr = json_decode($_POST['param'], true);
            $func = $arr['action'];
            App::$app->adminsc->$func($arr);
            exit();
         };
      }
      $routeView = ['js' => $this->route, 'view' => $this->view];
      View::setJsCss($routeView);
      $routeView = ['css' => $this->route, 'view' => $this->view];
      View::setJsCss($routeView);
   }

   public function actionProducts() {

      $fName = $fAct = $fArt = 0;
      $params = [];
      $where = $QSA = '';
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
         $page = (int) $_GET['page'];
         if ($page < 1)
            $page = 1;
      }else {
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
         $productsCnt = (INT) App::$app->product->productsCnt();
      }
      $cnt_pages = ceil($productsCnt / $perpage);
      if (!$cnt_pages)
         $cnt_pages = 1;

      if ($page > $cnt_pages)
         $page = $cnt_pages;
      $this->set(compact('products', 'productsCnt', 'cnt_pages', 'QSA'));
   }

   public function actionProduct() {

      if (isset($_GET['id'])) {
         $id = (int) View::e($_GET['id']);
      }
      $product = App::$app->product->getProduct($id);
      $category = App::$app->category->getCategory($product['parent']);
      $prodProps = App::$app->product->getProductProps($category);
      $props = App::$app->prop->getProps();
      $this->set(compact('product', 'category', 'props'));
   }

   public function actionIndex() {

      $iniCatList = App::$app->category->getInitCategories();
      $this->set(compact('iniCatList'));
   }

   public function actionCategories() {

      $iniCatList = App::$app->category->getInitCategories();
      $this->set(compact('iniCatList'));
   }

   public function actionCategory() {

      if (isset($_GET['id'])) {
         $id = (int) $_GET['id'];
      }
      if ($id) { /// иначе это корнвой каталог
         $category = App::$app->category->getCategory($id);
         $props = App::$app->prop->getProps();
      }
      $this->set(compact('category', 'props'));
   }

}
