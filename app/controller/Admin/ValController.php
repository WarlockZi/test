<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Val;

class ValController Extends AdminscController
{

	public string $model = Val::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex():void
	{

	}

}
