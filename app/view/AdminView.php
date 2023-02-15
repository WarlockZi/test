<?php


namespace app\view;


use app\view\Footer\AdminFooter;
use app\view\Header\AdminHeader;

class AdminView extends View
{
	public $layout = 'admin';

	protected $noViewError = "Файл вида не найден";

	public function __construct($route)
	{
		parent::__construct($route);
		$this->setHeader();
		$this->setFooter();
	}

	public function getHeader()
	{
		return $this->header->getHeader();
	}

	public function setHeader()
	{
		$this->header = new AdminHeader();
	}

	function getErrors()
	{
	}


	function setFooter()
	{
		$this->footer = new AdminFooter();
	}

	function getFooter()
	{
		return $this->footer->getFooter();
	}
}