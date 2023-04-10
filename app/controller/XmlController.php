<?php

namespace app\controller;

use app\Storage\XmlStorage;

class XmlController extends AppController
{
	public $model = xml::class;

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
		$path = ROOT . '/pic/integration.txt';
		file_put_contents($path, $text.'\n', FILE_APPEND);
//		echo "success\ncatalog\ncheckauth";
		echo "success";
//		header('Content-Type',null, 200);
	}

	public function action1s_exchange()
	{
		$coockieName = 'inc';
		$coockieVal = '456456';
		setcookie($coockieName, $coockieVal);
		echo "success";
//		header('Content-Type',null, 200);
	}

}


