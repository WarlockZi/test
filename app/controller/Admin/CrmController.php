<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
use app\core\Auth;
use app\model\User;
use app\view\View;


class CrmController extends AppController
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

	public function actionProdtypes()
	{
		$types = App::$app->adminsc->getProd_types();
		$this->setVars(compact('types'));
	}

	public function actionSiteMap()
	{
		$iniCatList = App::$app->category->getInitCategories();
		$this->setVars(compact('iniCatList'));
	}


	public function actionIndex():void
	{
//		View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
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


