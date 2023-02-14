<?php


namespace app\view;


use app\view\Header\AdminHeader;
use app\view\Header\Header;

class AdminView extends View
{
	public $layout = 'admin';
	protected $header;
	protected $noViewError = "Файл вида не найден";

	public function __construct($route)
	{
		parent::__construct($route);
		$this->setHeader();
	}

	public function setHeader()
	{
		$this->header = new AdminHeader();

//		Header::getAdminHeader();

	}

	function getErrors()
	{


	}
}