<?php

namespace app\controller;

use app\core\Base\View;
use app\core\Base\Controller;
use app\model\User;
use app\core\App;
use app\model\Prop;

class AdminscController extends AppController {

   public function __construct($route) {
      parent::__construct($route);


      if ($this->isAjax()) {

         if (isset($_POST['param'])) {
            $arr = json_decode($_POST['param'], true);

            if (!isset($arr['token']) || !$arr['token'] == $_SESSION['token']) {
               exit(FALSE);
            }
            $func = $arr['action'];
            $model = $arr['model'] ?: 'adminsc';
            if (App::$app->{$model}->$func($arr)) {
               exit('true');
            }
         }
      }
      $this->auth();
      $this->layout = 'admin';

      View::setJsCss(['js' => '/public/js/admin.js']);
      View::setJsCss(['css' => '/public/css/admin.css']);
   }

   public function actionClearCache() {
      $path = ROOT . "/tmp/cache/*.txt";
      array_map("unlink", glob($path));
      exit('Успешно');
   }

   public function actionProdtypes() {
      $types = App::$app->adminsc->getProd_types();
      $this->set(compact('types'));
   }

   public function actionSiteMap() {

      $iniCatList = App::$app->category->getInitCategories();
      $this->set(compact('iniCatList'));
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
      $this->vars['js'][] = $this->getJSCSS('.js');

      $this->set(compact('products', 'productsCnt', 'cnt_pages', 'QSA'));
   }

   public function actionIndex() {

      if ($_POST && count($_POST) == 1) {
         reset($_POST);
         $action = key($_POST);
         if (isset($_POST[$action])) {
            $this->$action();
         }
      }
// Проверяем существует ли пользователь и подтвердил ли регистрацию
      View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
   }

   public function OreplaceUnderlinesDashesInURLS() {

      $sql = "UPDATE products "
         . "SET durl = REPLACE(durl, '_','-')";
      App::$app->product->insertBySql($sql, $params);

      $sql = "UPDATE category "
         . "SET name = REPLACE(name, '_','-')";

      App::$app->product->insertBySql($sql, $params);

      $sql = "UPDATE products "
         . "SET durl = REPLACE(durl, '/catalog','')";

      App::$app->product->insertBySql($sql, $params);

      exit;
   }

   public function OFixPicNames() {

// уберем upload/iblock/ из dpic
      $sql = "UPDATE products SET dpic = REPLACE(dpic, '/upload/iblock', '')";
      App::$app->product->insertBySql($sql);
// уберем upload/iblock/ из preview_pic
      $sql = "UPDATE products SET preview_pic = REPLACE(preview_pic, '/upload/iblock', '')";
      App::$app->product->insertBySql($sql);

      header('settings');
   }

   public function fixProductsPath() {

//      $sql = "SELECT * FROM products";
//      $products = App::$app->product->findBySql($sql);
//      foreach ($products as $key => $value) {
//         $durl = $value['durl'];
//         $arr = explode('/', $durl);
//         $name = array_pop($arr);
//         $string =
//            "UPDATE products SET alias = '{$name}' where durl='{$durl}'";
//         $sql = str_replace('/', '\/', $string);
//         App::$app->product->insertBySql($string);
//      }
      exit;
   }

}
