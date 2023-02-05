<?php

namespace app\core;

use app\controller\AppController;
use app\controller\Controller;

class Router
{
  protected static $routes = [];
  protected static $route = [];

  public static function add($regexp, $route = [])
  {
    self::$routes[$regexp] = $route;
  }

  public static function matchRoute($url)
  {
    foreach (self::$routes as $pattern => $route) {
      if (preg_match("#$pattern#i", $url, $matches)) {
        foreach ($matches as $k => $v) {
          if (is_string($k)) { // превращаем нумеро7ванный массив в ассоциативный
            $route[$k] = $v;
          }
        }
        if (!isset($route['action'])) {
          $route['action'] = 'index';
        }
        $route['controller'] = isset($route['controller']) ? self::upperCamelCase($route['controller']) : '';

        self::$route = $route;
        return true;
      }
    }
    return false;
  }

  protected static function get404(
    string $error,
    string $action,
    Controller $controller = null)
  {
    http_response_code(404);
    $route = ['controller' => '404', 'action' => 'index'];
//		$this->view='vitex';
//    $controller = new AppController($route);
    $errorString = "bad - {$error}  = {$action}";
    $controller->set(compact('errorString'));
    $controller->setError(compact('errorString'));
    $controller->getView();
    exit();
  }

  protected static function getNameSpace($route)
  {
    if (isset($route['admin']) && $route['admin']) {
      return 'app\controller\admin\\';
    }
    return 'app\controller\\';
  }

  public static function dispatch($url)
  {
    require_once ROOT . '/app/core/routes.php';

    $url = self::removeQuryString($url);

    if (!self::matchRoute($url)) self::get404('url', $url);
    $nameSpace = self::getNameSpace(self::$route);
    $controller = $nameSpace . self::$route['controller'] . 'Controller';

    if (!class_exists($controller)) self::get404('controller', $controller);
    $controller = new $controller(self::$route);
    $action = 'action' . self::upperCamelCase(self::$route['action']); // . 'Action'; //Action для того, чтобы пользователь не мог обращаться к функции(хотя можно написать protected)

    if (!method_exists($controller, $action)) self::get404('action', $action, $controller);
    $controller->$action(); // Выполним метод
    $controller->getView(); // Подключим вид
  }

  protected static function upperCamelCase($name)
  {
    $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    return $name;
  }

  protected static function lowerCamelCase($name)
  {
    $name = str_replace('-', ' ', $name);
    $name = ucwords($name);
    $name = str_replace(' ', '', $name);
    $name = lcfirst($name);
    return $name;
  }

  protected static function removeQuryString($url)
  {
    if ($url) {
      $params = explode('&', $url, 2);
      if (!strpos($params[0], '=')) {
        return trim($params[0], '/');
      } else {
        return '';
      }
    }
  }
}
