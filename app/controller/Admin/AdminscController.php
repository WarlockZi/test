<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
use app\core\Auth;
use app\model\User;
use app\view\View;


class AdminscController extends AppController
{

	public function __construct()
	{
		parent::__construct();

		if (!User::isEmployee(Auth::getUser())){
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
		$this->set(compact('types'));
	}

	public function actionSiteMap()
	{
		$iniCatList = App::$app->category->getInitCategories();
		$this->set(compact('iniCatList'));
	}


	public function actionIndex()
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
		$this->set(compact('pics'));
	}

	public function actionDumpWWW()
	{
		if ($this->isAjax()) {
		}
	}


}


