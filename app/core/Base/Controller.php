<?php

namespace app\core\Base;

abstract class Controller {

   public $route;
   public $view;
   public $layout;
   public $jscss;
   public $vars = [];
   protected $token;

   function __construct($route) {
      $this->route = $route;
      $this->view = $route['action'];
      $this->token = !empty($_SESSION['token']) ? $_SESSION['token'] : $this->createToken();
   }

   protected function createToken() {
      $salt = "popiyonovacheesa";
      $token = $_SESSION['token'] = md5($salt . microtime(true));
      return $token;
   }

   public function getView() {
      $vObj = new View($this->route, $this->layout, $this->view);
      $vObj->render($this->vars);
   }

   // Передача данных в View
   public function set($vars) {
      $this->vars = array_merge($this->vars, $vars);
   }

   public function isAjax() {

      if (isset($_POST) && $_POST) {
         $data_json = json_decode($_POST['param'], true);
         $data = json_decode($_POST, true);
         if (isset($data_json['token'])) {
            if ($_SESSION['token'] !== $data_json['token']) {
               exit('Обновите страницу');
            }
         }
      }
//      exit($_POST);
      return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' || isset($_POST['ajax']) && ($_POST['ajax'] == 'true');
   }

   public
      function clean_data($str) {
      return mysqli_escape_string(strip_tags(trim($str)));
   }

}
