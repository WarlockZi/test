<?php


namespace app\view\Header;


use app\view\Interfaces\IHeaderable;
use app\view\View;

class AdminHeader implements IHeaderable
{
	protected $header;
	protected $user;


	public function __construct(array $user)
	{
		$this->user = $user;
		$this->setHeader($user);
		return $this->getHeader();
	}

	public function getHeader()
	{
		return $this->header;
	}
	public function setHeader($user)
	{
		$adminSidebar = $this->getSidebar();
		$adminHeader = $this->getTop();
		$this->header = $adminSidebar . $adminHeader;
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



}