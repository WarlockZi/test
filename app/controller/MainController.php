<?php

namespace app\controller;

use app\core\Base\View;
use app\core\App;

class MainController Extends AppController {

   public function __construct($route) {
      parent::__construct($route);

      $list = App::$app->cache->get('list');

      if (!$list) {
         $list = App::$app->category->getInitCategories();
         App::$app->cache->set('list', $list, 30);
      }
      $this->layout = 'vitex';
      $css = 'vitex.css';
      $js = $this->getJSCSS('.js');
      $this->set(compact('js', 'list', 'css'));
   }

   public function actionIndex() {
      // этот кусок вместо стандартной $this->auth()
      if (isset($_SESSION['id'])) {
         // Проверяем существует ли пользователь и подтвердил ли регистрацию
         $user = App::$app->user->getUserWithRightsSet($_SESSION['id']);
         if ($user === false) {
            // Если пароль или почта неправильные - показываем ошибку
            $errors[] = 'Неправильные данные для входа на сайт';
         } elseif ($user === NULL) {
            // Пароль почта в порядке, но нет подтверждения
            $errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
         } else {
            $rightId = explode(",", $user['rightId']);
            $this->set(compact('user', 'rightId'));
			$home = '';
            $this->set(compact('user', 'rightId','home'));
         }
         return TRUE;
      }
      View::setMeta('Спецодежда оптом с доставкой', 'Доставим спецодежду в любую точку России', 'Спецодежда, доставка, производство, по России');
   }



}
