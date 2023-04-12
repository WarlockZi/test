<?php

namespace app\controller;

use app\Storage\XmlStorage;

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
		$text = '';
		if (isset($_POST)) {
			$text .= json_encode($_POST);
		}
		if (isset($_FILES)) {
			$text .= json_encode($_FILES);
		}
		if (isset($_GET)) {
			$text .= json_encode($_GET);
		}
		setcookie($this->cookieName, $this->cookieVal);
		$path = ROOT . '/pic/integration.txt';
		file_put_contents($path, $text.'\n', FILE_APPEND);
		exit("success\n{$this->cookieName}\n{$this->cookieVal}");
//		echo "success\ncatalog\ncheckauth";
//		echo "success";
//		header('Content-Type',null, 200);
	}

	public function action1s_exchange()
	{

//		header('Content-Type',null, 200);
	}

}


