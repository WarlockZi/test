<?php

namespace app\core;

use app\model\User;
use app\controller\СatalogController;
use app\model\Category;

class Router {

   protected static $routes = [];
   protected static $route = [];
   protected static $aCategoryOrProduct = [];

   public static function add($regexp, $route = []) {
      self::$routes[$regexp] = $route;
   }

   public static function matchRoute($url) {

// если это категория
      if ($category = App::$app->category->isCategory($url)) {
         $route['controller'] = 'Catalog';
         $route['action'] = 'category';

         self::$route = $route;
         self::$aCategoryOrProduct = $category;
         return TRUE;

// это продукт
      } elseif ($product = App::$app->catalog->isProduct($url)) {

         $route['controller'] = 'Catalog';
         $route['action'] = 'product';

         self::$route = $route;
         self::$aCategoryOrProduct = $product;
         return TRUE;

// это страница не продукт и не категория
      } else {

         foreach (self::$routes as $pattern => $route) {

            if (preg_match("#$pattern#i", $url, $matches)) {

               foreach ($matches as $k => $v) {

                  if (is_string($k)) { // превращаем нумеро7ванный массив в ассоциативный
                     $route[$k] = $v;
                  }
               }
               // Если action не указан, подключить index
               if (!isset($route['action'])) {
                  $route['action'] = 'index';
               }
               $route['controller'] = isset($route['controller']) ? self::upperCamelCase($route['controller']) : '';

               self::$route = $route;
               return TRUE;
            }
         }
      }
      return FALSE;
   }

   public static function dispatch($url) {

      // Получим только неявные Get параметры(то, что после имени домена идет)
      $url = self::removeQuryString($url);
      if (self::matchRoute($url)) {

         // передаем route, из него в Contriller вычленяем (route[action] = view)
         $controller = 'app\controller\\' . self::$route['controller'] . 'Controller';
         $cObj = new $controller(self::$route);
         // Если удалось подключить класс
         if (class_exists($controller)) {
            $action = 'action' . self::upperCamelCase(self::$route['action']); // . 'Action'; //Action для того, чтобы пользователь не мог обращаться к функции(хотя можно написать protected)
            // Если удалось подключить метод Action
            if (method_exists($cObj, $action)) {
               $cObj->$action(self::$aCategoryOrProduct); // Выполним метод
               $cObj->getView(); // Подключим вид
            } else {
               echo "<br><b>$action</b> не найден...  ";
            }
         } else {
            echo "<br>Класс <b>$controller</b> не найден";
         }
      } else {
         http_response_code(404);
         include '../public/404.html'; // '404.html';
      }
   }

   public static function getRoutes() {
      return self::$routes;
   }

   public static function getRoute() {
      return self::$route;
   }

   protected static function upperCamelCase($name) {
      $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
      return $name;
   }

   protected static function lowerCamelCase($name) {
      $name = str_replace('-', ' ', $name);
      $name = ucwords($name);
      $name = str_replace(' ', '', $name);
      $name = lcfirst($name);
      return $name;
   }

   protected static function removeQuryString($url) {

      if ($url) {
         $params = explode('&', $url, 2);

         if (strpos($params[0], '=') === FALSE) {

            return trim(str_replace("XDEBUG_SESSION_START=netbeans-xdebug", "", $params[0]), '/');
         } else {
            return '';
         }
      }
   }

}
