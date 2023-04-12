<?php

namespace app\controller;

use app\core\Route;

class XmlController extends AppController
{
	public $model = xml::class;
	protected $cookieName = 'inc';
	protected $cookieVal = '456456';

	public function __construct()
	{
		parent::__construct();
	}

	public function actionInc()
	{
		if ($this->route->handler === '1c_exchange.php') {
			$this->setZipSize();
		} else {
			$this->setAuth();
		}
	}

	protected function setZipSize(){
		$text = $this->writeResp();
		$str = "zip=yes\nfile_limit=10000000000";
		$path = ROOT . '/pic/integration.txt';
		file_put_contents($path, $text, FILE_APPEND);
		exit($str);
	}

	protected function setAuth()
	{
		$text = $this->writeResp();
		$path = ROOT . '/pic/integration.txt';
		$ispath = is_file(ROOT . '/pic/integration.txt');
		file_put_contents($path, $text , FILE_APPEND);
		exit("success\n{$this->cookieName}\n{$this->cookieVal}");
	}

	protected function writeResp(){
		$text = time();
		if (isset($_POST)) {
			$text .= json_encode($_POST);
		}
		if (isset($_FILES)) {
			$text .= json_encode($_FILES);
		}
		if (isset($_GET)) {
			$text .= json_encode($_GET);
		}
		if (isset($_COOKIE)) {
			$text .= json_encode($_COOKIE);
		}
		return $text. '<br>';
	}

	protected function no()
	{
//		exit("f-{$ispath} - name {$path}");
		//		setcookie($this->cookieName, $this->cookieVal);
//		$date = date("D, d M Y H:i:s",strtotime('1 January 2024')) . 'GMT';
//		header("Set-Cookie: {$this->cookieName}={$this->cookieVal}; EXPIRES{$date};");
//		echo "success\ncatalog\ncheckauth";

	}

}


