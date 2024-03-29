<?php

namespace app\controller;


use app\core\Auth;
use app\core\FS;
use app\core\Router;
use app\model\User;
use app\view\AdminView;
use app\view\Assets\Assets;
use app\view\UserView;

abstract class Controller
{
	public $vars = [];

	protected $token;
	protected $route;
	protected $ajax;
	protected $auth;
	protected $layout;
	protected $layoutPath = ROOT . '/app/view/layouts/';

	protected $assets;

	function __construct()
	{
		if (!$this->isAjax()) {
			$this->assets = new Assets();
			$this->route = Router::getRoute();
			$this->token = $this->createToken();
		}
	}

	public function getView()
	{
		if ($this->route->isAdmin() && User::can(Auth::getUser(), ['role_employee'])) {
			return new AdminView($this);
		} else {
			return new UserView($this);
		}
	}

	public function getViewPath()
	{
		$admin = $this->route->admin ? 'Admin' : '';
		$path = FS::platformSlashes(ROOT . "/app/view/" . "{$this->route->controllerName}/" . $admin);
		return $path;
	}

	protected function createToken(): string
	{
		return $_SESSION['token'] = session_id();
	}

	public function getLayout(): string
	{
		$layout = $this->layoutPath . $this->layout . '.php';
		if (is_readable($layout)) {
			return $layout;
		}
		return false;
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function set($vars)
	{
		$this->vars = array_merge($this->vars, $vars);
	}


	public function badToken(array $data): bool
	{
		if (!$data || !isset($data['token']) || !$data['token']) return false;
		if (!$_SESSION['token'] === $data['token']
		) {
			unset($data['token']);
			return true;
		}
		return false;
	}

	public function getAssets(): Assets
	{
		return $this->assets;
	}

	public function isAjax(): array
	{
		if (isset($_POST['param'])) {

			$req = json_decode($_POST['param'], true);

			if ($this->badToken($req)) return [];

			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
				unset($req['token']);
				$this->ajax = $req;
				return $req;
			}
		}
		return [];
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

}
