<?php

namespace app\controller;

use app\model\Video;
use app\view\View;

class VideoinstructionsController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setJs('admin.js');
		View::setCss('admin.css');
	}

	public function actionIndex()
	{
	}

	public function actionUpdateOrCreate()
	{
	}


	public function actionDelete()
	{
	}

	public function actionShow()
	{
	}


}
