<?php


namespace app\view;


use app\controller\Controller;
use app\core\Error;
use app\core\FS;
use app\model\User;
use app\view\Assets\UserAssets;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\Header\UserHeader;

class UserView extends View
{
	protected $layout = ROOT . "/app/view/layouts/vitex.php";
	protected static $noViewError = ROOT . '/app/view/404/index.php';

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->setAssets();
		$this->header = new UserHeader();
//		$this->setHeader($this->user, $this->controller->settings);
		$this->setFooter();
	}

	public static function getManagerSelector()
	{
		$u = User::where('rights', 'LIKE', '%role_manager%')->get();
		$select = SelectNewBuilder::build(
			ArrayOptionsBuilder::build($u)
				->initialOption()
				->get()
		)
			->get();
		return $select;

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

	public function setHeader($user, $settings)
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