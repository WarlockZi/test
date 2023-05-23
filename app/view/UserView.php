<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\model\Product;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;
use Illuminate\Database\Eloquent\Model;

class UserView extends View
{
	protected $layout = ROOT . "/app/view/layouts/vitex.php";
	protected static $noViewError = ROOT . '/app/view/404/index.php';

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->setAssets();
		$this->setHeader($this->user);
		$this->setFooter();
	}

	protected function getViewFile(Controller $controller): string
	{
//		var_dump($controller);
		$route = $this->controller->getRoute();
//		var_dump($route);
		$action = property_exists($controller, 'view') ? $controller->view : $route->action;
		$controller = ucfirst($route->controllerName);
		return FS::platformSlashes(ROOT . "/app/view/{$controller}/{$action}.php");
	}

	public function get404(): string
	{
		return FS::getFileContent(self::$noViewError);
	}

	public function setContent(Controller $controller): void
	{
		if (is_readable($this->view)) {
			$this->content = self::getFileContent($this->view, $controller->vars);
		} else {
			Error::setError("Нет файла вида - {$controller->getRoute()->action}");
			$this->content = self::getFileContent(self::$noViewError);
		}
	}

	public function setHeader($user)
	{
		$this->header = new UserHeader($user);
	}

	public function setFooter()
	{
		$this->footer = FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
	}

	public function getFooter()
	{
		return $this->footer;
	}

	protected function setAssets()
	{
		$this->assets = new UserAssets();
		$this->assets->merge($this->controller->getAssets());

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