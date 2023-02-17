<?php

namespace app\controller\Admin;

use app\controller\AppController;

class MorphController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
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
