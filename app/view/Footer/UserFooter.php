<?php


namespace app\view\Footer;


use app\core\FS;

class UserFooter extends AbstractFooter
{
	public function __construct()
	{
		$this->setFooter();
	}

	public function setFooter()
	{
		$this->footer= FS::getFileContent(ROOT . '/app/view/Footer/footerView.php');
	}

	public function getFooter()
	{
		return $this->footer;
	}
}