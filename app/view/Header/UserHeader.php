<?php


namespace app\view\Header;


use app\core\FS;
use app\Repository\SettingsRepository;
use app\view\Header\BlueRibbon\BlueRibbon;


class UserHeader
{
	public $route;
	public $header;
	public $frontCategories;
	public $index;
	public $logo;

	public $phone;
	public $location;
	public $userMenu;

	public $path = __DIR__.'/templates/';
	public $pathBlue = __DIR__.'/BlueRibbon/templates/';

	public function __construct($route)
	{
		$this->route = $route;
		$header = $this;
		$this->blueRibbon = (new BlueRibbon())->getTemplate();
		$this->phone = (FS::getFileContent($this->path.'phone.php'));
		$settings = (new SettingsRepository())->all();
		$this->location = FS::getFileContent($this->path.'location.php', compact('settings'));
		$this->userMenu = FS::getFileContent($this->path.'user_menu.php');
		$this->logo = FS::getFileContent($this->path.'logo.php', compact('route'));
		$this->phone = FS::getFileContent($this->pathBlue . 'searchPanel.php');
		$this->loc = FS::getFileContent($this->pathBlue  . 'searchPanel.php');
//		$this->logo = FS::getFileContent($this->pathBlue  . 'searchPanel.php');
		$this->gUserMenu = FS::getFileContent($this->pathBlue  . 'searchPanel.php');
		$this->gSearchPanel = FS::getFileContent($this->pathBlue  . 'searchPanel.php');
		$this->gHeader = $this->header;
		$this->header =
			FS::getFileContent($this->path.'vitex_header.php',
				compact('header'));
	}

}