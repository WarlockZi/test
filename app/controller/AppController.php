<?php

namespace app\controller;

use app\model\User;
use app\view\View;

class AppController extends Controller
{
	protected $ajax;
	protected $user;

	public function __construct(array $route)
	{
		parent::__construct($route);
		if (isset($route['admin'])) {
			$this->setAdminAssets();
			$this->autorize();
		} else {
			$this->setMainAssets();
		}
		$this->isAjax();
	}

	protected function setMainAssets()
	{
		$this->layout = 'vitex';
		View::setJs('main.js');
		View::setCss('main.css');
		View::setJs('mainHeader.js');
		View::setCss('mainHeader.css');
		View::setJs('common.js');
		View::setCss('common.css');
		View::setJs('cookie.js');
		View::setCss('cookie.css');
		View::setJs('list.js');
		View::setCss('list.css');
	}

	protected function setAdminAssets()
	{
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
//		View::setJs('list.js');
//		View::setCss('list.css');
//		View::setJs('common.js');
//		View::setCss('common.css');
	}

	public function actionDelete()
	{
		if ($this->ajax['id']) {
			if ($this->model::delete($this->ajax['id'])) {
				$this->exitWithPopup('Удален');
			}
		} else {
			$this->exitWithMsg('No id');
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$id = $this->model::updateOrCreate($this->ajax);
			if (is_numeric($id)) {
				$this->exitJson(['popup' => 'Сохранен', 'id' => $id]);
			} elseif (is_bool($id)) {
				$this->exitWithPopup('Сохранено');
			} else {
				$this->exitWithError('Ответ не сохранен');
			}
		}
	}

	public function exitJson(array $arr = []): void
	{
		if ($arr) {
			exit(json_encode(['arr' => $arr]));
		}
	}

	public function exitWithPopup(string $msg): void
	{
		if ($msg) {
			exit(json_encode(['popup' => $msg]));
		}
		exit();
	}

	public function exitWithMsg(string $msg): void
	{
		if ($msg) {
			exit(json_encode(['msg' => $msg]));
		}
		exit();
	}

	public function exitWithSuccess(string $msg): void
	{
		if ($msg) {
			exit(json_encode(['success' => $msg]));
		}
		exit();
	}

	public function exitWithError(string $msg): void
	{
		if ($msg) {
			exit(json_encode(['error' => $msg]));
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
				$this->exitWithPopup("Пользователь не найден");
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
				$this->user = $user;
			}
		}
	}

	public function auth()
	{
		if (isset($_SESSION['id']) && $_SESSION['id']) {
			$user = $this->user = User::findOneWhere('id', $_SESSION['id']);
			if ($this->user === false) {
				$errors[] = 'Неправильные данные для входа на сайт';
			} else {
				$this->set(compact('user'));
			}
		}
	}

}
