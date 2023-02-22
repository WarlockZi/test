<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\view\Assets\AdminAssets;
use app\view\Header\AdminHeader;

class AdminView extends View
{
	protected $layout = ROOT . "/app/view/layouts/admin.php";
	protected $noViewError = "Файл вида не найден";

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);

		$this->setHeader($this->user);
		$this->setFooter();
		$this->setAssets();
	}

	protected function getViewFile(): string
	{
		$route = $this->controller->getRoute();
		$controller = ucfirst($route->controller);
		$action = $route->action;
		return FS::platformSlashes(ROOT . "/app/view/{$controller}/Admin/{$action}.php");
	}

	protected function setContent(Controller $controller): void
	{

		if (is_readable($this->view)) {
			$this->content = self::getFileContent($this->view, $controller->vars);
		} else {
			Error::setError("Нет файла вида - Admin/view");
			$this->content = self::getFileContent($controller->view);
		}
	}

	public function getHeader()
	{
		return $this->header->getHeader();
	}

	public function setHeader($user)
	{
		$this->header = new AdminHeader($user);
	}

	function getErrors()
	{
	}


	function setFooter()
	{
		ob_start();
		include ROOT . '/app/view/Footer/footerView.php';
		$this->footer = ob_get_clean();
	}

	function getFooter()
	{
		return $this->footer;
	}


	function getLayout()
	{
		return $this->layout;
	}

	protected function setAssets()
	{
		$this->assets = new AdminAssets();
	}
}