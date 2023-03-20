<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Auth;
use app\model\User;
use app\Services\XMLParser\Parser2;
use app\Services\XMLParser\XMLParser;


class xmlController extends AppController
{
	public $model = xml::class;

	public function __construct()
	{
		parent::__construct();

		if (!User::isEmployee(Auth::getUser())){
			header('Location:/auth/profile');
		}
	}

	public function actionIndex()
	{
		if (isset($_POST['file'])){

			$parser = new XMLParser($_POST['file']);
//			$parser = new Parser2($_POST['file']);

		}
	}
}


