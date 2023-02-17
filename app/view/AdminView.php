<?php


namespace app\view;


use app\core\Auth;
use app\core\Error;
use app\view\Footer\AdminFooter;
use app\view\Header\AdminHeader;

class AdminView extends View
{
	protected $layout = ROOT . "/app/view/layouts/admin.php";
	protected $noViewError = "Файл вида не найден";

	public function __construct($route)
	{
		parent::__construct($route);
		$this->user = Auth::getUser();
		$this->setHeader($this->user);
		$this->setFooter();
	}

	public function setContent(array $route, array $vars): void
	{
		$action = $this->view ? $this->view : $route['action'];
		$file = ROOT . "/app/view/{$route['controller']}/Admin/{$action}.php";
		if (is_readable($file)) {
			$this->content = self::getFileContent($file, $vars);
		} else {
			Error::setError("Нет файла вида - Admin/{$route['action']}.php");
			$this->content = self::getFileContent($this->view);
		}
	}

	public function getHeader()
	{
		return $this->header->getHeader();
	}

	public function setHeader($user)
	{
		$this->header = new AdminHeader($user);
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


	function getLayout()
	{
		return $this->layout;
	}
}