<?php

namespace app\controller;

use app\core\Base\View;
use app\model\User;
use app\model\Catalog;
use app\core\App;


class MainController Extends AppController {

   public function __construct($route) {
      parent::__construct($route);

      $list = App::$app->cache->get('list');
      if (!$list) {
         $list = App::$app->category->getInitCategories();
         App::$app->cache->set('list', $list, 30);
      }

      $sale = App::$app->cache->get('sale');
      if (!$sale) {
         $sale = App::$app->product->getSale();
         App::$app->cache->set('sale', $sale, 30);
      }

      $this->layout = 'vitex';

      View::setJsCss(['css'=>'/public/css/vitex.css']);
      View::setJsCss(['js'=> $this->route, 'view'=>$this->view]);
      View::setJsCss(['css'=> $this->route, 'view'=>$this->view]);
      $this->set(compact('sale','list'));
   }

   public function actionIndex() {
      // этот кусок вместо стандартной $this->auth()
      if (isset($_SESSION['id'])) {
         // Проверяем существует ли пользователь и подтвердил ли регистрацию
         $user = App::$app->user->getUser($_SESSION['id']);
         if ($user === false) {
            // Если пароль или почта неправильные - показываем ошибку
            $errors[] = 'Неправильные данные для входа на сайт';
         } elseif ($user === NULL) {
            // Пароль почта в порядке, но нет подтверждения
            $errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
         } else {

            $this->set(compact('user'));
         }
         return TRUE;
      }
      View::setMeta('Медицинские расходные материалы', 'Доставим медицинские расходные материалы в любую точку России', 'медицинские расходные материалы, доставка, производство, по России');
   }




   public function actionRequisites() {

   }
   public function actionDiscount() {

   }
   public function actionDelivery() {

   }
   public function actionPayment() {
   }
   public function actionContacts() {
   }

   public function actionOferta() {

   }
   public function actionAbout() {

   }
   public function actionReturn_change() {

   }
   public function actionArticles() {

   }




}
