<?php


namespace app\view\Footer;


class UserFooter extends AbstractFooter
{
	public function __construct()
	{
		$this->setFooter();
	}

	public function setFooter()
	{
		ob_start();
		include ROOT . '/app/view/Footer/footerView.php';
		$this->footer= ob_get_clean();
	}

	public function getFooter()
	{
		return $this->footer;
	}
}