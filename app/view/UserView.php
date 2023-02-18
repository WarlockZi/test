<?php


namespace app\view;


use app\core\Error;
use app\view\Header\UserHeader;

class UserView extends View
{
	protected $layout = ROOT . "/app/view/layouts/vitex.php";
	protected static $noViewError = ROOT . '/app/view/404/index.php';

	public function __construct($route)
	{
		parent::__construct($route);
		$this->setHeader($this->user);
		$this->setFooter();
		$this->setAssets();
	}

	protected function setContent(array $route, array $vars): void
	{
		$action = $this->view ? $this->view : $route['action'];
		$file = ROOT . "/app/view/{$route['controller']}/{$action}.php";
		if (is_readable($file)) {
			$this->content = self::getFileContent($file, $vars);
		} else {
			Error::setError("Нет файла вида - {$route['action']}.php");
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

	protected function setAssets()
	{
//    $this->layout = 'vitex';
		View::setJs('main.js');
		View::setCss('main.css');
		View::setJs('mainHeader.js');
		View::setCss('mainHeader.css');
//		View::setJs('breadcrumbs.js');
//		View::setCss('breadcrumbs.css');
		View::setJs('cookie.js');
		View::setCss('cookie.css');

//    View::setJs('list.js');
//    View::setCss('list.css');

		View::setJs('product.js');
		View::setCss('product.css');
//    View::setJs('card.js');

		View::setCDNJs("https://cdn.quilljs.com/1.3.6/quill.js");
		View::setCDNCss("https://cdn.quilljs.com/1.3.6/quill.snow.css");
//    View::setCDNCss("https://cdn.quilljs.com/1.3.6/quill.bubble.css");
//		View::setJs('list.css');
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