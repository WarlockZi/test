<?php

namespace app\controller;

use app\core\App;
use app\view\View;
use app\controller\AdminscController;

class Adm_crmController extends AdminscController
{

	public function __construct($route)
	{
		parent::__construct($route);

	}

	public function actionIndex()
	{

	}


	public function actionTestResults()
	{
		$res = App::$app->testresult->findAll('testResults');
		$this->set(compact('res'));
	}

	public function actionTestResult()
	{
		$files = $this->getFiles(ROOT . '/tmp/cache/test_results');
		$this->set(compact('files'));
	}



}
