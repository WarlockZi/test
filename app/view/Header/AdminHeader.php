<?php


namespace app\view\Header;


use app\view\View;

class AdminHeader
{
	protected static $header;

	public function __construct()
	{
		$this->setHeader();
		return $this->getHeader();
	}


	protected function setHeader()
	{
		$adminSidebar = $this->getSidebar();
		$adminHeader = $this->getTop();
		self::$header = $adminSidebar . $adminHeader;
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
	protected function getTop()
	{
		ob_start();
		include ROOT . '/app/view/Header/admin/admin_header.php';
		return ob_get_clean();
	}

	protected function getSidebar()
	{
		ob_start();
		include ROOT . '/app/view/Header/admin/admin_menu__accordion.php';
		$res = ob_get_clean();
		return $res;
	}
	public static function getHeader()
	{
		return self::$header;
	}


}