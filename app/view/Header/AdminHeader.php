<?php


namespace app\view\Header;


use app\core\FS;
use app\model\User;
use app\view\Interfaces\IHeaderable;

class AdminHeader implements IHeaderable
{
	protected $header;
	protected $user;
	protected $path;

	public function __construct(array $user)
	{
		$this->user = $user;
		$this->path = __DIR__.'/';
		$this->setHeader($user);
		return $this->getHeader();
	}

	public function getHeader()
	{
		return $this->header;
	}

	public function setHeader($user)
	{
		$logo = FS::getFileContent(ROOT . '/app/view/Header/admin/logo_VITEX_grey.php');
		$chips = User::can($user)
			? FS::getFileContent(ROOT . '/app/view/Header/admin/chips.php')
			: '';
		$user_menu = FS::getFileContent(ROOT . '/app/view/Header/user_menu.php');
		$searchPanel = FS::getFileContent($this->path . '/searchPanel.php');
		$searchButton = FS::getFileContent($this->path . '/searchButton.php');

		$vars = compact('user', 'logo', 'chips', 'user_menu', 'searchPanel','searchButton');
		$adminSidebar = FS::getFileContent($this->path .'admin/admin_menu__accordion.php', $vars);
		$adminHeader = FS::getFileContent($this->path .'admin/admin_header.php', $vars);
		$this->header = $adminSidebar . $adminHeader;
	}


}