<?php


namespace app\view\Header\BlueRibbon;


use app\core\FS;
use app\Repository\CategoryRepository;
use app\Repository\OrderRepository;

class BlueRibbon
{
	protected $headerCategories;
	protected $categories;
	protected $searchPanel;
	protected $searchButton;
	protected $cart;
	protected $offer;
	protected $mobileMenu;
	protected $path;

	public function __construct()
	{
		$this->path = __DIR__.'/templates/';
	}

	public function getCategories(){
		$categories = CategoryRepository::getHeaderCategories();
		return FS::getFileContent($this->path.'categories.php',compact('categories'));
	}
	public function getSearchPanel(){
		return FS::getFileContent($this->path.'searchPanel.php');
	}
	public function getSearchButton(){
		return FS::getFileContent($this->path.'searchButton.php');
	}
	public function getCart(){
		$oItems = OrderRepository::count();
		return FS::getFileContent($this->path.'cart.php',compact('oItems'));
	}
	public function getOffer(){
		return 	FS::getFileContent($this->path.'offer.php');
	}
	public function getMobileMenu()
	{
		return FS::getFileContent($this->path . 'mobileMenu.php');
	}

	public function getTemplate(){
		$categories = $this->getCategories();
		$searchButton = $this->getSearchButton();
		$searchPanel= $this->getSearchPanel();
		$cart = $this->getCart();
		$offer = $this->getOffer();
		$mobileMenu = $this->getMobileMenu();


		return FS::getFileContent($this->path.'template.php',
			compact(
				'searchPanel',
				'categories',
				'searchButton',
				'cart',
				'offer',
				'mobileMenu'
			));

			;
	}

}