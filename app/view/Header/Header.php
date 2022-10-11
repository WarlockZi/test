<?php


namespace app\view\Header;


use app\controller\Controller;
use app\model\Illuminate\Category;

class Header
{

	public static function getMenu(Controller $controller, array $frontCategories)
	{
		ob_start();
		include ROOT . '/app/view/Header/header_menu.php';
		return ob_get_clean();
	}

	public static function getHeader(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/Header/vitex_header.php';
		return ob_get_clean();
	}

	public static function getVitexHeader(Controller $controller)
	{
		$frontCategories = Category::showFrontCategories();
		$headerMenu = self::getMenu($controller, $frontCategories);
		$header = self::getHeader($controller);
		$controller->set(compact(
			'frontCategories',
			'headerMenu',
			'header',
			));
	}


	public static function getTopAdmin(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/Header/admin/admin_header.php';
		return ob_get_clean();
	}

	public static function getAdminMenu(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php';
		return ob_get_clean();
	}

	public static function getLogo(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/Header/logo.php';
		return ob_get_clean();
	}


	public static function getAdninHeader(Controller $controller)
	{
		$adminMenu = self::getAdminMenu($controller);
		$adminHeader = self::getTopAdmin($controller);
		$controller->set(compact('adminHeader','adminMenu'));
	}


	public static function getChips(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php';
		return ob_get_clean();
	}


	public static function getUserMenu(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php';
		return ob_get_clean();
	}
}