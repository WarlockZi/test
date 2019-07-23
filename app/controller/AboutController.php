<?php

namespace app\controller;

use app\core\Base\View;
use app\model\User;
use app\model\Catalog;
use app\core\App;

class AboutController extends AppController {

   public function __construct($route) {
      parent::__construct($route);
      $this->layout = 'vitex';
      $css = 'vitex.css';
      $list = App::$app->category->getInitCategories();
      $this->set(compact('list', 'css'));
   }

   public function actionIndex() {

//      $cats_id = App::$app->category->getInitCategories();
//
//      View::setMeta('Каталог спецодежды', 'Каталог спецодежды', 'Каталог спецодежды');
//      $this->set(compact('cats_id', 'user'));
   }
   public function actionRequisites() {

   }

   public function actionOferta() {

   }
   public function actionReturn_change() {

   }


}
