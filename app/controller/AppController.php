<?php

namespace app\controller;

use app\core\App;
use app\model\User;
use Dotenv\Store\StringStore;

class AppController extends Controller
{
  protected $ajax;
  protected $user;

  public function __construct(array $route)
  {
    parent::__construct($route);
    $this->layout = 'vitex';
    $this->isAjax();
  }

	public function exitJson(array $arr=[]): void
	{
		if ($arr) {
			exit(json_encode($arr));
		}
	}

  public function exitWith(string $msg): void
  {
    if ($msg) {
      exit(json_encode(['msg' => $msg]));
    }
    exit();
  }

  public function setAuth($user)
  {
    $_SESSION['id'] = (int)$user['id'];
  }

  public function preparePassword(string $password): string
  {
    $salt = "popiyonovacheesa";
    return md5($password . $salt);
  }

  public function autorize()
  {

    if (!isset($_SESSION['id']) || !$_SESSION['id']) {
      header("Location:/auth/login");
      $_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
      exit();
    } else {
      $user = User::findOneWhere('id', $_SESSION['id']);
      if (!$user) {
        header("Location:/auth/login");
        $this->exitWith("Пользователь не найден");
      }
      if ($user === false) {
        $_SESSION['id'] = '';
        $errors[] = 'Неправильные данные для входа на сайт';
        header("Location:/user/login");
      } elseif (!$user['confirm'] == "1") {
        $errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
        header("Location:/auth/noconfirm");

      } else {
        if ($user['email'] === $_ENV['SU_EMAIL']) {
          define('SU', true);
        }
        $this->user=$user;
      }
    }
  }

  public function auth()
  {
    if (isset($_SESSION['id']) && $_SESSION['id']) {

      $user = $this->user = User::findOneWhere('id', $_SESSION['id']);

      if ($this->user === false) {
        $errors[] = 'Неправильные данные для входа на сайт';
//			} elseif ($this->user['confirm'] !== "1") {
//				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
      } else {
        $this->set(compact('user'));
      }
    }
  }


//  public function hierachy($array, $parentName)
//  {
//    {
//      $tree = [];
//      foreach ($array as $id => &$node) {
//        if (!$node[$parentName] && isset($node[$parentName])) {
//          $tree[$id] = &$node;
//        } else {
//          $array[$node[$parentName]]['childs'][$id] = &$node;
//        }
//      }
//      return $tree;
//    }
//  }
}
