<?php

namespace app\controller;

use app\core\App;
use \app\model\Prop;
use app\core\Base\View;

class CatalogController extends AppController {

   public function __construct($route) {
      parent::__construct($route);
      $this->layout = 'vitex';
      $css = 'vitex.css';
      $list = App::$app->category->getInitCategories();
      $this->set(compact('list', 'css'));
   }

   public function actionIndex() {

      $cats_id = App::$app->category->getInitCategories();
      View::setMeta('Каталог спецодежды', 'Каталог спецодежды', 'Каталог спецодежды');
      $this->set(compact('cats_id', 'user'));
   }

   public function actionProduct($product) {

      header('Cache-Control: private, max-age=8400');
      header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

      $js = '/public/jscss/Catalog/index.js';
      $this->set(compact('js'));

      $parents = $product['parents'];
      $breadcrumbs = App::$app->catalog->getBreadcrumbs($product, $product['parents'], 'product');

      if (isset($_SESSION['id']) && $_SESSION['id']) {
         $urerId = $_SESSION['id'];
         $user = App::$app->user->getUserWithRightsSet($urerId);
      }
      $canonical = $product['title'];
      View::setMeta($product['title'], $product['description'],$product['keywords']);
      $this->set(compact('breadcrumbs', 'user', 'product', 'tov', 'categories'));
      $this->set(compact('canonical'));
//      $this->set(compact('user', 'tov'));
   }

   public function actionCategory($category) {

      $js = '/public/jscss/Catalog/index.js';

      if (isset($_SESSION['id'])) {
         $id = $_SESSION['id'];
         $user = App::$app->user->getUser($id);
      }

      $breadcrumbs = App::$app->catalog->getBreadcrumbs($category, $category['parents'], 'category');
      $canonical = $category['alias'];
      View::setMeta($category['title'], $category['description'],$category['keywords']);
      $this->set(compact('user', 'breadcrumbs', 'category', 'js','canonical'));
   }

}
