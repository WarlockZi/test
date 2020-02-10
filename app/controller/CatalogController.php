<?php

namespace app\controller;

use app\core\App;
use \app\model\Prop;
use app\core\Base\View;

class CatalogController extends AppController {

   public function __construct($route) {
      parent::__construct($route);
//      $this->layout = 'vitex';
//      $list = App::$app->category->getInitCategories();
//      $this->set(compact('list'));
      View::setCss(['css' => '/public/css/vitex.css', 'addtime']);

   }

   public function actionIndex() {

      $cats_id = App::$app->category->getInitCategories();
      View::setMeta('Каталог спецодежды', 'Каталог спецодежды', 'Каталог спецодежды');
      $this->set(compact('cats_id', 'user'));
   }

   public function actionProduct($product) {

      header('Cache-Control: private, max-age=8400');
      header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
      $this->view = 'product';

//      $parents = $product['parents'];
      $breadcrumbs = App::$app->product->getBreadcrumbs($product, $product['parents'], 'product');

      if (isset($_SESSION['id']) && $_SESSION['id']) {
         $id = $_SESSION['id'];
         $user = App::$app->user->getUser($id);
      }
      $canonical = $product['alias'];
      View::setMeta($product['title'], $product['description'], $product['keywords']);
//      'user', , 'categories', 'tov'
      $this->set(compact('canonical', 'breadcrumbs', 'product'));

      View::setCss(['css' => $this->route['controller'], 'view' => $this->view, 'addtime']);
   }

   public function actionCategory($category) {

      if (isset($_SESSION['id']) && $_SESSION['id']) {
         $user = App::$app->user->getUser($_SESSION['id']);
			$this->set(compact('user'));
      }

      $breadcrumbs = App::$app->product->getBreadcrumbs($category, $category['parents'], 'category');
      $canonical = $category['alias'];
      View::setMeta($category['title'], $category['keywords'], $category['description']);
      $this->set(compact( 'breadcrumbs', 'category', 'canonical'));
//      $this->view = 'category';
      View::setCss(['controller' => $this->route['controller'], 'view' => $this->view, 'addtime']);
   }

}
