<?php


namespace app\view\Header;


use app\core\FS;
use app\model\User;
use app\view\Interfaces\IHeaderable;

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
		$logo = FS::getFileContent(ROOT.'/app/view/Header/admin/logo_VITEX_grey.php');
		$chips = User::can($user)
			?FS::getFileContent(ROOT.'/app/view/Header/admin/chips.php')
			:'';
		$user_menu = FS::getFileContent(ROOT . '/app/view/Header/user_menu.php');
		$vars = compact('user','logo','chips','user_menu');
		$adminSidebar = $this->getSidebar($vars);
		$adminHeader = $this->getTop($vars);
		$this->header = $adminSidebar . $adminHeader;
	}

	protected function getTop(array $arr)
	{
		return FS::getFileContent(ROOT . '/app/view/Header/admin/admin_header.php', $arr);
	}

	protected function getSidebar(array $arr)
	{
		return FS::getFileContent(ROOT . '/app/view/Header/admin/admin_menu__accordion.php', $arr);
	}



}