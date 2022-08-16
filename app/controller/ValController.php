<?php

namespace app\controller;


use app\model\Illuminate\Category;
use app\view\components\Tree\Tree;

class ValController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{

	}

}
