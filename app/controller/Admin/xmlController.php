<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\model\User;
use app\Services\XMLParser\Parser2;
use app\Services\XMLParser\XMLParser;
use app\Services\XMLParser\XMLParser3;


class xmlController extends AppController
{
	public $model = xml::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
//		if (isset($_POST['file'])){
    $_POST['file']='d';

			$parser = new XMLParser3($_POST['file']);
//			$parser = new Parser2($_POST['file']);

//		}
	}
}


