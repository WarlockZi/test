<?php

namespace app\controller;

use app\core\App;
use app\view\View;

class PlanningController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);

		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');

		$this->autorize();
	}

	public function actionIndex()
	{


	}
	public function actionCreate()
	{


	}

	public function actionDelete()
	{
		if (App::$app->answer->delete($this->ajax['a_id'])) {
			exit(json_encode(['msg' => 'ok']));
		}

	}

	public function actionShow()
	{


	}

}
