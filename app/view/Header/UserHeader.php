<?php


namespace app\view\Header;


use app\controller\FS;
use app\core\Icon;
use app\core\Router;
use app\model\Category;
use app\view\Interfaces\IHeaderable;
use app\view\View;

class UserHeader implements IHeaderable
{
	protected $header;

	public function __construct($user)
	{
		$this->user = $user;
		$this->setHeader($user);
//		return $this->getHeader();
	}

	public function getHeader()
	{
		return $this->header;
	}
	public function setHeader($user)
	{

		$frontCategories = Category::frontCategories();

		$frontCategories = FS::getFileContent(ROOT . '/app/view/Header/header_menu.php');


		$index = Router::isHome();
		$logo = Icon::logo_squre1() . Icon::logo_vitex1();

		ob_start();
		include ROOT . '/app/view/Header/vitex_header.php';
		$this->header = ob_get_clean();

		$this->setAssets();
	}


	protected function setAssets()
	{
		View::setJs('admin.js');
		View::setCss('admin.css');

		View::setJs('list.js');
		View::setCss('list.css');

		View::setJs('common.js');
		View::setCss('common.css');

		View::setJs('product.js');
		View::setCss('product.css');
	}




}