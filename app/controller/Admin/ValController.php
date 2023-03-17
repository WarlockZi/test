<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Val;

class ValController Extends AppController
{

	public $model = Val::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{

	}

}
