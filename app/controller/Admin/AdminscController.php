<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
use app\core\Auth;
use app\model\User;


class AdminscController extends AppController
{
	public function __construct()
	{
		parent::__construct();

		if (!Auth::getUser()->isEmployee()){
			header('Location:/auth/profile');
		}

	}
	public function actionClearCache()
	{
		$path = ROOT . "/tmp/cache/*.txt";
		array_map("unlink", glob($path));
		exit('Успешно');
	}


	public function actionSiteMap()
	{
		$iniCatList = App::$app->category->getInitCategories();
		$this->setVars(compact('iniCatList'));
	}


	public function actionIndex():void
	{
//		$this->assets->setCDNJs("https://cdn.jsdelivr.net/npm/chart.js", true);
	}


	public function createSiteMap()
	{
	}

	public function actionDumpSQL()
	{
	}

	public function actionPics()
	{
		$pics = App::$app->adminsc->findAll('pic');
		$this->setVars(compact('pics'));
	}

	public function actionDumpWWW()
	{

	}


}


