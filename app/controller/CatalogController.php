<?php

namespace app\controller;

use app\core\Base\View;
use app\core\App;

class CatalogController extends AppController {

   public function __construct($route) {
      parent::__construct($route);
      $this->layout = 'vitex';
      $css = 'vitex.css';
      $list = App::$app->category->getInitCategories();
      $this->set(compact('list', 'css'));
   }

   public function actionIndex() {

      //exit(__FILE__. ' имя категории - ' );
      $cats_id = App::$app->category->getInitCategories();

      View::setMeta('Каталог спецодежды', 'Каталог спецодежды', 'Каталог спецодежды');
      $this->set(compact('cats_id', 'user'));
   }

   public function actionProduct() {

      if (!$this->route['cat3']) {// значит одна подкатегория
         $cat1 = $this->route['cat1'];
         $tov = $this->route['cat2'];
      } else {
         $cat1 = $this->route['cat1'];
         $cat2 = $this->route['cat2'];
         $tov = $this->route['cat3'];
      }

      View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
      $this->set(compact('user', 'tov'));
   }

   public function actionCategory($aCategory) {

      header('Cache-Control: private, max-age=8400');
      header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

      $js = '/public/jscss/Catalog/index.js';
      $this->set(compact('js'));

      $parents = $aCategory['parents'];
      $breadcrumbs = App::$app->catalog->getBreadcrumbs($aCategory, $parents);

      $products = $aCategory['children']['products'];
      $categories = $aCategory['children']['categories'];

      if ($urerId = $_SESSION['id']) {
         $user = App::$app->user->getUserWithRightsSet($urerId);
      }
      View::setMeta($lastParent, $lastParent, $lastParent);
      $this->set(compact('breadcrumbs','user', 'products', 'tov', 'categories'));

      }

//   }
   }
