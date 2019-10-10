<?php

namespace app\controller;

use app\model\User;
use app\core\Base\Controller;
use app\core\Base\View;
use app\core\App;

class AppController extends Controller {

   public function __construct($route) {

      parent::__construct($route);
      $this->layout = 'vitex';
      View::setJs([
          'js' => '/public/js/jq.js',
          ]);
      View::setJs([
          'js' => '/public/js/auto.js',
          'addtime'
          ]);

   }

   public static function debug($arr) {
      echo '<pre>' . print_r($arr, true) . '</pre>';
   }

   public function getFromCache($cache_path) {

      $this->auth();
      if (is_array($this->route)) {
         if (array_key_exists('cache', $this->route)) {
            if ($this->route['cache']) {
               $cache = $this->route['cache'];
            }
         }
      }

      $file = CACHE . $cache_path . $cache . '.txt';
      if (file_exists($file)) {
         $results = require $file;
      }
      $this->set(compact('results'));
      exit();
   }

//   public function getJSCSS($extension) {
//      $doCache = DEBU ? "?" . time() : '';
//      $controller = $this->route['controller'];
//      $view = $this->view;
//      $js = PROJ . "/public/jscss/" . $controller . '/' . $view . $extension . $doCache;
//      return $js;
//   }

   public function auth() {
      try {
         if (isset($_SESSION['id']) && !$_SESSION['id'] && $_SERVER['QUERY_STRING'] != '') { // REDIRECT на регистрацию, если запросили не корень
            throw new \Exception();
         } elseif (isset($_SESSION['id'])) {
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
         } elseif (!isset($_SESSION['id'])) {
            header("Location:" . PROJ . "/user/login");
            $_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
            exit();
         }
      } catch (\Exception $e) {
         header("Location:" . PROJ . "/user/login");
         $_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
         exit();
      };
   }

}
