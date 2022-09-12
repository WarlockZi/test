<?php


namespace app\view\Header;


use app\controller\Controller;
use app\model\Illuminate\Category;

class Header
{
	public static function getHeader(Controller $controller)
	{
		ob_start();
		include ROOT.'/app/view/Header/vitex_header.php';
		return ob_get_clean();
	}

	public static function getMenu(Controller $controller,array $frontCategories)
	{
		ob_start();
		include ROOT.'/app/view/Header/header_menu.php';
		return ob_get_clean();
	}

	public static function getVitexHeader(Controller $controller)
	{
		$frontCategories = Category::showFrontCategories();
		$headerMenu = self::getMenu($controller,$frontCategories);
		$header = self::getHeader($controller);
		$controller->set(compact(
			'header',
			'frontCategories',
			'headerMenu'
		));
	}


	public static function getTopAdmin(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/Header/admin/admin_header.php';
		return ob_get_clean();
	}

	public static function getAdninHeader(Controller $controller)
	{
		$adminHeader = self::getTopAdmin($controller);
		$controller->set(compact('adminHeader',));
	}
}