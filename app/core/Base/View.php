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

   public static function getJsCssProps($data, $ext) {
      $noCache = isset($data['nocache']) ? false : true;
      $doCache = DEBU && $noCache ? "?" . time() : '';
      $defer = isset($data['defer']) ? 'defer' : '';
      $async = isset($data['defer']) ? 'async' : '';
      $deferAsync = $defer ?: $async;
      if (isset($data['controller']) && isset($data['view'])) {
         $file = ROOT . "/public/jscss/" . $data['controller'] . '/' . $data['view'] . '.' . $ext;
         if (is_readable($file)) {
            if ($ext == 'js') {
               $jscss = "<script {$deferAsync} src='{$script}{$doCache}'></script>";
            } else {
               $jscss = "<link href='{$script}{$doCache}' type='text/css' rel='stylesheet'>";
            }
            self::$jsCss[$ext][] = $jscss;
         }
      }
      else{
         return compact('doCache', 'deferAsync');

      }
   }

   public static function setJs($data) {
      extract(self::getJsCssProps($data, 'js'));
      self::$jsCss['js'][] = "<script {$deferAsync} src='$data[$ext]{$doCache}'></script>";
   }

   public static function setCss($data) {
      extract(self::getJsCssProps($data, 'css'));
      self::$jsCss['css'][] = "<link href='$data[$ext]{$doCache}' type='text/css' rel='stylesheet'>";
   }

   public static function setJsCss($data) {
   }

   public static function getCSS() {
      $css = '';
      $arr = self::$jsCss['css'];
      if (is_array($arr)) {
         foreach ($arr as $v) {
            $css .= $v;
//            $css .= "<link type='text/css' rel='stylesheet' href='{$value}'>";
         }
      }
      echo $css;
   }

   public static function getJS() {
// если передали route. значит хотим подключить индивид.
// скрипт, если не передали, то тот который передали
      $js = '';
      if (is_array(self::$jsCss['js'])) {
         foreach (self::$jsCss['js'] as $v) {
            $js .= $v;
         }
      }
      echo $js;
   }

   public static function getMeta() {
      echo '<title>' . self::$meta['title'] . '</title>
               <meta name = "description" content = "' . self::$meta['desc'] . '">
               <meta name = "keywords" content = "' . self::$meta['keywords'] . '">';
   }

   public static function setMeta($title = '', $description = '', $keywords = '') {
      self::$meta['title'] = $title;
      self::$meta['desc'] = $description;
      self::$meta['keywords'] = $keywords;
   }

   public static function e($str) {
      return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
   }

}
