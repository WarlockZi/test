<?php

namespace app\controller;

use app\core\App;
use app\core\Auth;
use app\core\Session;
use app\model\User;
use app\view\Header\Header;
use app\view\View;


class AdminscController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);

//		Auth::autorize($this);
		if (!User::can(Session::getUser(), ['role_employee'])) {
			header('Location:/auth/profile');
		}
//		Header::setAdninHeader($this);
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


