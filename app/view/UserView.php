<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\Repository\SelectorRepository;
use app\Repository\UserRepository;
use app\view\Assets\UserAssets;
use app\view\Header\UserHeader;

class UserView extends View
{
	protected $layout = ROOT . "/app/view/layouts/vitex.php";
	protected static $noViewError = ROOT . '/app/view/404/index.php';
	protected $canonical;

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->setCanonical($controller);
		$this->setAssets();
		$this->header = new UserHeader($controller->getRoute());
		$this->setFooter();
	}

	public static function getManagerSelector()
	{
			return SelectorRepository::userManager(UserRepository::userManager());
	}

	protected function getViewFile(Controller $controller): string
	{
		$route = $this->controller->getRoute();
		$action = property_exists($controller, 'view') ? $controller->view : $route->action;
		$controller = ucfirst($route->controllerName ?? '');
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

	public function setHeader()
	{
		$this->header = new UserHeader();
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

	public function setCanonical(Controller $controller)
	{
		$route = $controller->getRoute();
		if ($route->getControllerName() == "Short") {
			$slug = $controller->vars['product']->slug;
			$href = "$route->protocol://$route->host/product/{$slug}";
			$this->canonical = "<link rel='canonical' href={$href}>";
		} else {
			$this->canonical = '';
		}
	}

	public function getCanonical()
	{
		return $this->canonical;
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