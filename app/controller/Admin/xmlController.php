<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
use app\core\Auth;
use app\model\User;
use app\Services\XMLParser\XMLParser;
use app\view\View;


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

		}

//		View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
	}


}


