<?php

namespace app\controller;
use app\model\TestResult;

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
		$res = TestResult::findAll('testResults');
		$this->set(compact('res'));
	}

	public function actionTestResult()
	{
		$files = $this->getFiles(ROOT . '/tmp/cache/test_results');
		$this->set(compact('files'));
	}



}
