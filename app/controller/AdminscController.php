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
      $this->layout = 'admin';
      $this->vars['js'] = $this->getJSCSS('.js'); //'admin.js';
      $this->vars['css'] = '/public/css/admin.css';

      if ($this->isAjax()) {
         if (isset($_POST['param'])) {
            $arr = json_decode($_POST['param'], true);
            $func = $arr['action'];
            App::$app->adminsc->$func($arr);
            exit('okey');
         };
      }
   }

   public function actionProdtypes() {
      $this->auth();

      $types = App::$app->adminsc->getProd_types();
      $this->set(compact('types'));
   }

   public function actionSiteMap() {

      $this->auth();

      $iniCatList = App::$app->category->getInitCategories();
      $this->set(compact('iniCatList'));
   }

   public function actionProductEdit() {

      $this->auth();

      $productId = $this->route['id'];
      $this->vars['css'] = $this->getJSCSS('.css');
      $product = App::$app->catalog->getProduct($productId);

      $i = 0;
      while ($product['parent']) {
         $category = App::$app->catalog->getCategory($product['parent'])[0];
         $catProps = Prop::getByIds([$category['prop']]);
         foreach ($catProps as $key) {
            $i++;
            $categoryProps[$i] = $key;
         }
         $product['parent'] = $category['parent'];
      };
//         unset($categoryProps[0]);


      $this->set(compact('product', 'categoryProps'));
   }

   public function actionProducts() {

      $this->auth();

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
         $products = App::$app->catalog->findBySql($sql, $params);
         $sql = "SELECT * FROM products $where";
         $productsCnt = count(App::$app->catalog->findBySql($sql, $params));
         $cnt_pages = ceil($productsCnt / $perpage);
         if (!$cnt_pages)
            $cnt_pages = 1;

         if ($page > $cnt_pages)
            $page = $cnt_pages;
      } else {

         $sql = "SELECT * FROM products LIMIT $start_pos,$perpage";
         $products = App::$app->catalog->findBySql($sql);
         $productsCnt = (INT) App::$app->catalog->productsCnt();
      }
      $cnt_pages = ceil($productsCnt / $perpage);
      if (!$cnt_pages)
         $cnt_pages = 1;

      if ($page > $cnt_pages)
         $page = $cnt_pages;

      $this->set(compact('products', 'productsCnt', 'cnt_pages', 'QSA'));
   }

   public function actionUsers() {

      $this->auth();

      $users = App::$app->user->findAll('users');

      foreach ($users as $key => $value) {
         $userId = $value['id'];
         $user_rights_set = App::$app->user->getUserRightsSet($userId);
         foreach ($user_rights_set as $k) {

            $users[$key]['rights_set'][] = $k['name'];
         }
      }

      $rights = App::$app->user->findAll('user_rights');
      ;

      $this->set(compact('users', 'rights'));
   }
   
   public function actionUser() {

//      $this->auth();

      $users = App::$app->user->findAll('users');

      foreach ($users as $key => $value) {
         $userId = $value['id'];
         $user_rights_set = App::$app->user->getUserRightsSet($userId);
         foreach ($user_rights_set as $k) {

            $users[$key]['rights_set'][] = $k['name'];
         }
      }

      $rights = App::$app->user->findAll('user_rights');
      ;

      $this->set(compact('users', 'rights'));
   }

   public function actionIndex() {

      $this->auth();

      if ($_POST && count($_POST) == 1) {
         reset($_POST);
         $action = key($_POST);
         if (isset($_POST[$action])) {
            $this->$action();
         }
      }

// Проверяем существует ли пользователь и подтвердил ли регистрацию
//      $user = App::$app->user->getUserById($_SESSION['id']);

      View::setMeta('Администрирование', 'Администрирование', 'Администрирование');

//      $this->set(compact('user'));
   }

   public function replaceUnderlinesDashesInURLS() {

      $sql = "UPDATE products "
         . "SET durl = REPLACE(durl, '_','-')";

      App::$app->catalog->insertBySql($sql, $params);

      $sql = "UPDATE category "
         . "SET name = REPLACE(name, '_','-')";

      App::$app->catalog->insertBySql($sql, $params);

      $sql = "UPDATE products "
         . "SET durl = REPLACE(durl, '/catalog','')";

      App::$app->catalog->insertBySql($sql, $params);

      exit;
   }

   public function fixPicNames() {

//      $sql = "UPDATE pic SET nameHash = REPLACE(nameHash, nameHash, concat(nameHash,'.jpg')) where nameHash = '26602552'";
// уберем .jpg из nameHash  
//      $sql = "UPDATE pic SET nameHash = REPLACE(nameHash, nameHash, concat(nameHash,'\.jpg'))";
//      App::$app->catalog->insertBySql($sql);
// уберем upload/iblock/ из dpic
//      $sql = "UPDATE products SET dpic = REPLACE(dpic, '/upload/iblock', '')";
//      App::$app->catalog->insertBySql($sql);
// уберем upload/iblock/ из preview_pic
      $sql = "UPDATE products SET preview_pic = REPLACE(preview_pic, '/upload/iblock', '')";
      App::$app->catalog->insertBySql($sql);


      header('settings');
   }

   public function fixProductsPath() {
// уберем /letnaya/bla bla/
//      $sql = "SELECT * FROM products where durl='/letnyaya-spetsodezhda/kostyumy-dlya-itr/kostyum-gudzon-1/'";
//      $sql = "SELECT * FROM products";
//      $products = App::$app->catalog->findBySql($sql);
//      foreach ($products as $key => $value) {
//         $durl = $value['durl'];
//         $arr = explode('/', $durl);
//         $name = array_pop($arr);
//         $name = array_pop($arr);
//         $string = 
//            "UPDATE products SET alias = '{$name}' where durl='{$durl}'";
//         $sql = str_replace('/', '\/', $string);
//         App::$app->catalog->insertBySql($string);
//      }
      exit;
   }

}
