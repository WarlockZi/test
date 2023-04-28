<?php


namespace app\view\Header;


use app\core\FS;
use app\model\Category;
use app\Repository\OrderRepository;
use app\view\Interfaces\IHeaderable;
use app\view\View;

class UserHeader implements IHeaderable
{
	protected $header;
	protected $frontCategories;
	protected $index;
	protected $logo;
	protected $path = ROOT . '/app/view/Header/';

	public function __construct($user)
	{
		$this->user = $user;
		$this->setHeader($user);
	}

	public function getHeader()
	{
		return $this->header;
	}

	public function getFileContent(string $file)
	{
		ob_start();
		require $this->path . $file;
		return ob_get_clean();
	}

	public function setHeader($user)
	{
		$this->frontCategories = $frontCategories = Category::frontCategories();
		$oItems = OrderRepository::count();
		$searchPanel = FS::getFileContent($this->path.'/searchPanel.php');

		$this->frontCategories = FS::getFileContent($this->path.'/header_menu.php',compact('oItems','frontCategories','searchPanel'));

		$this->logo = $this->getFileContent('logo.php');

		$this->header = $this->getFileContent('vitex_header.php');
	}
}