<?php


namespace app\view;


use app\controller\Controller;
use app\core\Auth;
use app\core\Error;
use app\view\Footer\AdminFooter;
use app\view\Header\AdminHeader;

class AdminView extends View
{
	protected $layout = ROOT . "/app/view/layouts/admin.php";
	protected $noViewError = "Файл вида не найден";

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->user = Auth::getUser();
		$this->setHeader($this->user);
		$this->setFooter();
	}

	protected function setContent(Controller $controller): void
	{
		$action = $controller->view;

		if (is_readable($action)) {
			$this->content = self::getFileContent($action, $controller->vars);
		} else {
			Error::setError("Нет файла вида - Admin/view");
			$this->content = self::getFileContent($controller->view);
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