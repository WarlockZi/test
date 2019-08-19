<?php

namespace app\core\Base;

class View {

   public $route;
   public $layout;
   public $view;
   public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
   public static $jsCss = ['js' => '', 'css' => ''];

   function __construct($route, $layout = '', $view = '') {

      $this->route = $route;
      // Если в вид передали false то и в $this->layout устанавливаем false для отключения layout
      if ($layout === false) {
         $this->layout = false;
      } else {

         $this->layout = $layout ?: ''; //LAYOUT;
      }
      $this->view = $view;
   }

   public function render($vars) {
      if (is_array($vars)) {
         extract($vars);
      }
      $file_view = ROOT . "/app/view/{$this->route['controller']}/{$this->view}.php";
      // если режим отладки вкл, ставим метку и не кешируем
      ob_start();
      if (is_file($file_view)) {
         require $file_view;
      } else {
         echo "<br>Не найден файл вида {$this->view} ";
      }
      $content = ob_get_clean();
      ob_start();
      // Если в вид передали false то и в $this->layout устанавливаем false для отключения layout
      if ($this->layout !== FALSE) {
         $file_layout = ROOT . "/app/view/layouts/{$this->layout}.php";
         if (is_file($file_layout)) {
            require $file_layout;
         } else {
            '<br> Не найден шаблон Layout' . $this->layout;
         }
      }
      $page_cache = ob_get_clean();
      echo $page_cache;
   }

   public static function setJsCss($jsCss) {
      $js = '';
      $extension = '.'.array_keys($jsCss)[0];
      if (isset($jsCss['js']) && $jsCss['js']) {
         // если передан массив - это route>подключим индивид файл
         if (is_array($jsCss['js'])) {
            $doCache = DEBU ? "?" . time() : '';
            $controller = $jsCss['js']['controller'];
            $view = $jsCss['view'];
            $script = "/public/jscss/" . $controller . '/' . $view . $extension;
            $file = ROOT . $script;
            if (is_readable($file)) {
               $js .= "<script src='{$script}{$doCache}'></script>";
            }
         } else {
            self::$jsCss['js'][] = $jsCss['js'];
         }
      } elseif (isset($jsCss['css']) && $jsCss['css']) {
         self::$jsCss['css'][] = $jsCss['css'];
      }
   }

   public static function getCSS() {
      $css = '';
      if (is_array(self::$jsCss['css'])) {
         foreach (self::$jsCss['css'] as $value) {
            $css .= "<link type='text/css' rel='stylesheet' href='{$value}'>";
         }
      }
      echo $css;
   }
   public static function getJS() {
// если передали route. значит хотим подключить индивид.
// скрипт, если не передали, то тот который передали
      $js = '';
      if (is_array(self::$jsCss['js'])) {
         foreach (self::$jsCss['js'] as $value) {
            $js .= "<script src='{$value}'></script>";
         }
      }
      echo $js;
   }
   public static function getMeta() {
      echo '<title>' . self::$meta['title'] . '</title>
               <meta name = "description" content = "' . self::$meta['desc'] . '">
               <meta name = "keywords" content = "' . self::$meta['keywords'] . '">';
   }

   public static function e($str) {
      return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
   }
}
