<?php


namespace app\view\Header;


use app\controller\Controller;
use app\core\Icon;
use app\model\Category;


class Header
{
	protected static $adminHeader;
	protected static $userHeader;

	public static function getTopAdmin(Controller $controller)
	{
		ob_start();
		include ROOT . '/app/view/Header/admin/admin_header.php';
		return ob_get_clean();
	}

	public static function getAdminSidebar(Controller $controller)
	{
			ob_start();
			include ROOT . '/app/view/Header/admin/admin_menu__accordion.php';
			$res = ob_get_clean();
			return $res;
	}

	public static function setAdninHeader(Controller $controller)
	{
		$adminSidebar = self::getAdminSidebar($controller);
		$adminHeader = self::getTopAdmin($controller);
		self::$adminHeader = $adminSidebar.$adminHeader;
	}



	public static function setUserHeader(Controller $controller)
	{
		$frontCategories = self::getMenu();
		$index = ($controller->route['action'] === "index" && $controller->route['controller'] == "Main");
		$logo = Icon::logo_squre1().Icon::logo_vitex1();
		ob_start();
		include ROOT . '/app/view/Header/vitex_header.php';
		self::$userHeader =  ob_get_clean();
	}

	public static function getMenu()
	{
		$frontCategories = Category::frontCategories();
		ob_start();
		include ROOT . '/app/view/Header/header_menu.php';
		return ob_get_clean();
	}


	public static function getUserHeader(){
		return self::$userHeader;
	}
	public static function getAdminHeader(){
		return self::$adminHeader;
	}
}