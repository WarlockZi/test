<?php

namespace app\controller\Admin;

use app\controller\AppController;

class MorphController Extends AdminscController
{

	public function __construct(array $route)
	{
		parent::__construct();
	}

	public function actionAttach()
	{
		if ($_FILES){
			$morph = ucfirst($_POST['morph']['type']);
			$controller = "app\controller\Admin\\{$morph}Controller";
			$controller = new $controller([]);
			$controller->attachOne();
		}
	}
}
