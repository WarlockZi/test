<?php


namespace app\view\Header;


use app\core\FS;
use app\Repository\SettingsRepository;
use app\view\Header\BlueRibbon\BlueRibbon;


class UserHeader
{
	protected $header;
	protected $frontCategories;
	protected $index;
	protected $logo;

	protected $phone;
	protected $location;
	protected $userMenu;

	protected $path = __DIR__.'/templates/';

	public function __construct()
	{
		$header = $this;
		$this->header = FS::getFileContent($this->path.'vitex_header.php',compact('header'));
	}
	public function blueRibbon(){
		return (new BlueRibbon())->getTemplate();
	}
	public function phone(){
		return FS::getFileContent($this->path.'phone.php');
	}
	public function location(){
		$settings = (new SettingsRepository())->all();
		return FS::getFileContent($this->path.'location.php', compact('settings'));
	}
	public function userMenu(){
		return FS::getFileContent($this->path.'user_menu.php');
	}
	public function logo(){
		return FS::getFileContent($this->path.'logo.php');
	}

	protected function getPhone(){
		return FS::getFileContent($this->path . '/searchPanel.php');
	}

	protected function getLocation(){
		return FS::getFileContent($this->path . '/searchPanel.php');
	}

	protected function getUserMenu(){
		return FS::getFileContent($this->path . '/searchPanel.php');
	}

	protected function getSearchPanel(){
		return FS::getFileContent($this->path . '/searchPanel.php');
	}

	public function getHeader()
	{
		return $this->header;
	}
}