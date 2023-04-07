<?php

namespace app\controller;

class XmlController extends AppController
{
	public $model = xml::class;

	public function __construct()
	{
		parent::__construct();
	}


	public function actionInt()
	{

		$text = '';
		if (isset($_POST)){
			$text .= json_encode($_POST);
		}
		if (isset($_FILES)){
			$text .= json_encode($_FILES);
		}
		if (isset($_GET)){
			$text .= json_encode($_GET);
		}
		$path = ROOT.'/pic/integration.txt';
		file_put_contents($path,$text);
//		echo "success\ncatalog\ncheckauth";
//		header('Content-Type',null, 200);
	}
		public function action1c_exchange()
	{
		echo "success\n1s\nintegr";
//		header('Content-Type',null, 200);
	}



}


