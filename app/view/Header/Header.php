<?php


namespace app\view\Header;


use app\controller\Controller;
use app\core\Icon;
use app\model\Category;
use Illuminate\Database\Eloquent\Collection;


class Header
{

	public static function getMenu(Controller $controller, Collection $frontCategories)
	{
		ob_start();
		include ROOT . '/app/view/Header/header_menu.php';
		return ob_get_clean();
	}

	public static function getHeader(Controller $controller, $headerMenu)
	{
		$index = ($controller->route['action'] === "index" && $controller->route['controller'] == "Main");
		$logo = Icon::logo_squre1().Icon::logo_vitex1();
		ob_start();
		include ROOT . '/app/view/Header/vitex_header.php';
		return ob_get_clean();
	}

	public static function getVitexHeader(Controller $controller)
	{
		$frontCategories = Category::frontCategories();
		$headerMenu = self::getMenu($controller, $frontCategories);
		$header = self::getHeader($controller,$headerMenu);
		$controller->set(compact(
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
//		$cache = Cache::get('admin_sidebar');
//		if ($cache){
//			return $cache;
//		}else{
//			ob_start();
//			include ROOT . '/app/view/Header/admin/admin_menu__accordion.php';
//			$res = ob_get_clean();
//			Cache::set('admin_sidebar',$res);
//			return $res;
//		}

			ob_start();
			include ROOT . '/app/view/Header/admin/admin_menu__accordion.php';
			$res = ob_get_clean();
			return $res;

	}

	public static function setAdninHeader(Controller $controller)
	{
		$adminMenu = self::getAdminMenu($controller);
		$adminHeader = self::getTopAdmin($controller);
		$controller->set(compact('adminHeader','adminMenu'));
	}



//	public static function getUserMenu(Controller $controller)
//	{
//		ob_start();
//		include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php';
//		return ob_get_clean();
//	}
}