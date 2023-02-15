<?php


namespace app\view\Header;


use app\view\Interfaces\IHeaderable;
use app\view\View;

class AdminHeader implements IHeaderable
{
	protected static $header;
	protected $footer;

	public function __construct()
	{
//		$this->setFooter();
		$this->setHeader();
		return $this->getHeader();
	}

	public function getHeader()
	{
		return self::$header;
	}
	public function setHeader()
	{
		$adminSidebar = $this->getSidebar();
		$adminHeader = $this->getTop();
		self::$header = $adminSidebar . $adminHeader;
		$this->setAssets();
	}

//	public function getFooter()
//	{
//		return $this->footer;
//	}
//	public function setFooter()
//	{
//		$this->footer = AbstractFooter::getAdminFooter();
//
//	}

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



}