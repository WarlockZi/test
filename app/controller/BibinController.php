<?php


namespace app\controller;


use app\core\App;

class BibinController extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->layout = 'empty';
	}

	public function actionIndex()
	{



	}

}