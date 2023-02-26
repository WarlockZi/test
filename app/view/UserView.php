<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;

class UserView extends View
{
	protected $layout = ROOT . "/app/view/layouts/vitex.php";
	protected static $noViewError = ROOT . '/app/view/404/index.php';

	public function __construct(Controller $controller)
	{
		$this->setAssets($controller);
		parent::__construct();
		$this->setHeader($this->user);
		$this->setFooter();
	}
	protected function getViewFile(): string
	{
		$route = $this->controller->getRoute();
		$controller = ucfirst($route->controller);
		$action = $route->action;
		return FS::platformSlashes(ROOT . "/app/view/{$controller}/{$action}.php");
	}

	protected function setContent(Controller $controller): void
	{
		if (is_readable($this->view)) {
			$this->content = self::getFileContent($this->view, $controller->vars);
		} else {
			Error::setError("Нет файла вида - {$route['action']}");
			$this->content = self::getFileContent($this->view);
		}
	}

	public function setHeader($user)
	{
		$this->header = new UserHeader($user);

	}

	public function setFooter()
	{
		ob_start();
		include ROOT . '/app/view/Footer/footerView.php';
		$this->footer = ob_get_clean();
	}

	public function getFooter()
	{
		return $this->footer;
	}

	protected function setAssets(Controller $controller)
	{
		$this->assets = new UserAssets($controller);
	}

	protected static function get404()
	{
		return self::$noViewError;
	}

	function getErrors()
	{
		if (Error::getErrorHtml()) {
			include self::get404();
		}
	}

	function getHeader()
	{
		return $this->header->getHeader();
	}


	function getLayout()
	{
		return $this->layout;
	}
}