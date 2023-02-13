<?php


namespace app\view;


use app\core\Error;
use app\core\Icon;
use app\core\Router;
use app\model\Category;

class UserView extends View
{
	public $layout = 'vitex';
	protected static $get404 = ROOT . '/app/view/404/index.php';
	protected $header;

	public function __construct($route)
	{
		parent::__construct($route);
		$this->setHeader();
		$this->setFooter();
		$this->setAssets();
	}

	public function setHeader()
	{
		$frontCategories = Category::frontCategories();
		ob_start();
		include ROOT . '/app/view/Header/header_menu.php';
		$frontCategories = ob_get_clean();

		$route = Router::getRoute();
		$index = ($route['action'] === "index" && $route['controller'] == "Main");
		$logo = Icon::logo_squre1() . Icon::logo_vitex1();
		ob_start();
		include ROOT . '/app/view/Header/vitex_header.php';
		$this->header = ob_get_clean();
	}

	public function setFooter(){

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
		return self::$get404;
	}

	function getErrors()
	{
		if (Error::getErrorHtml()){
			include self::get404();
		}
	}
}