<?php

namespace app\controller;

use app\core\App;
use app\model\User;
use app\view\View;


class AdminscController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		if (User::can($this->user, ['role_employee'])) {
			View::setJs('common.js');
			View::setJs('admin.js');
			View::setCss('admin.css');
			View::setJs('vendors.js');
		} else {
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
		View::setMeta('Администрирование', 'Администрирование', 'Администрирование');
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


