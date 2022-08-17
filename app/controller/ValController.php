<?php

namespace app\controller;


use app\model\Val;

class ValController Extends AppController
{

	public $model = Val::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{

	}

}
