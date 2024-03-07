<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\view\Assets\AdminAssets;
use app\view\Assets\TestAssets;
use app\view\Header\Admin\AdminHeader;


class AdminView extends View
{
	protected $layout = ROOT . "/app/view/layouts/admin.php";
	protected $noViewError = "Файл вида не найден";
	protected $defaultView = ROOT . "/app/view/default.php";
	protected $view;

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);

		$this->setView($controller);
		$this->setLayout($controller);
		$this->setHeader($this->user);
		$this->setFooter();

		$this->setAssets();

	}

	protected function setView($controller)
	{
		if (property_exists($controller, 'view')) {
			$file = $controller->getViewPath() . '/' . $controller->view . '.php';
			if (is_file($file)) {
				$this->view = $file;
			}
		}
	}

	protected function getViewFile(): string
	{
		$route = $this->controller->getRoute();
		$controller = ucfirst($route->getControllerName());
		$action = $route->getAction();
		return FS::platformSlashes(ROOT . "/app/view/{$controller}/Admin/{$action}.php");
	}

	protected function setLayout(Controller $controller)
	{
		$layout = $controller->getLayout();
		$this->layout = $layout ? $layout : $this->layout;
	}

	public function setContent(Controller $controller): void
	{
		if (is_readable($this->view)) {
			$this->content = self::getFileContent($this->view, $controller->vars);
		} else {
			$action = $controller->getRoute()->getAction();
			$model = ucfirst($controller->getRoute()->getControllerName());
			Error::setError("Нет файла вида - {$model}/Admin/{$action}");
			$this->content = self::getFileContent($this->defaultView, $this->controller->vars);
		}
	}

	public function get404(): string
	{
		return $this->noViewError;
	}

	public function getHeader()
	{
		return $this->header->getHeader();
	}

	public function setHeader($user)
	{
		$this->header = new AdminHeader($user);
	}

	function setFooter()
	{
		$this->footer = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
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
		$this->assets->merge($this->controller->getAssets());
	}

	protected function setTestAssets()
	{
		$this->assets = new TestAssets();
	}

	function getErrors()
	{
		// TODO: Implement getErrors() method.
	}
}