<?php

namespace app\controller\Admin;

use app\controller\AppController;


class IntegrationController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}


	public function actionIndex()
	{
		echo "success\ncatalog\ncheckauth";
//		header('Content-Type',null, 200);
	}
	public function action1c_exchange()
	{
		echo "success\n1s\nintegr";
//		header('Content-Type',null, 200);
	}

}


