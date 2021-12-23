<?php

namespace app\controller;

use app\core\App;
use Dotenv\Store\StringStore;

class AppController extends Controller
{
	protected $ajax;
	protected $user;
	protected $salt = "popiyonovacheesa";

	public function __construct(array $route)
	{

		parent::__construct($route);
		$this->layout = 'vitex';
		$this->isAjax();

		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = $this->user = App::$app->user->get($_SESSION['id']);
			if (!$user) $_SESSION['id']='';

			if ($user['email'] === $_ENV['SU_EMAIL']) {
				define('SU', true);
			} else {
				define('SU', false);
			}
		}
	}


	public
	function setAuth($user)
	{
		if (!isset($_SESSION['id']) || !$_SESSION['id']) {
			$_SESSION['id'] = (int)$user['id'];
		}
	}

	public
	function preparePassword(String $password): String
	{
		return md5($password . $this->salt);
	}

	public
	function autorize()
	{
		if (!isset($_SESSION['id']) || !$_SESSION['id']) {
			header("Location:/user/login");
			$_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
			exit();
		} else {
			$user = $this->user = App::$app->user->get($_SESSION['id']);

			if ($this->user === false) {
				$errors[] = 'Неправильные данные для входа на сайт';
				header("Location:/user/login");
			} elseif ($this->user['confirm'] !== "1") {
				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			} else {
				$this->set(compact('user'));
			}
		}
	}
	public
	function auth(){
		if (isset($_SESSION['id']) && $_SESSION['id']) {

			$user = $this->user = App::$app->user->get($_SESSION['id']);

			if ($this->user === false) {
				$errors[] = 'Неправильные данные для входа на сайт';
//			} elseif ($this->user['confirm'] !== "1") {
//				$errors[] = 'Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.';
			} else {
				$this->set(compact('user'));
			}
		}
	}


	public function hierachy($array, $parentName)
	{
		{
			$tree = [];
			foreach ($array as $id => &$node) {
				if (!$node[$parentName] && isset($node[$parentName])) {
					$tree[$id] = &$node;
				} else {
					$array[$node[$parentName]]['childs'][$id] = &$node;
				}
			}
			return $tree;
		}
	}
}
