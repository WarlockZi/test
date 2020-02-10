<?php

namespace app\controller;

use app\core\Base\Controller;
use app\core\App;

class AppController extends Controller
{
	protected $list;

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->layout = 'vitex';
		if (strpos(strtolower($route['controller']), 'adminsc') === false) {
			$list = App::$app->category->getAssocCategory(['active'=>'true']);
			$this->list = App::$app->category->categoriesTree($list);
			$this->set(compact('list'));
		}
	}

	public
	function getFromCache($cache_path)
	{
		$this->auth();
		if (is_array($this->route) && array_key_exists('cache', $this->route)) {
			if ($this->route['cache']) {
				$cache = $this->route['cache'];
			}
		}

		$file = CACHE . $cache_path . $cache . '.txt';
		if (file_exists($file)) {
			$results = require $file;
		}
		$this->set(compact('results'));
		exit();
	}

	public
	function auth()
	{
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
				header("Location:/user/login");
				$_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
				exit();
			}
		} catch (\Exception $e) {
			header("Location:/user/login");
			$_SESSION['back_url'] = $_SERVER['QUERY_STRING'];
			exit();
		};
	}

}
