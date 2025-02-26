<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\App;
use app\core\Auth;
use app\model\User;
use app\view\View;


class CrmController extends AdminscController
{

	public function __construct()
	{
		parent::__construct();

		if (!Auth::userIsEmployee()){
			header('Location:/auth/profile');
		}
	}
	public function actionClearCache(): void
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

	public function actionSiteMap(): void
    {
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

	public function actionPics(): void
    {
		$pics = App::$app->adminsc->findAll('pic');
		$this->setVars(compact('pics'));
	}

	public function actionDumpWWW()
	{

	}


}


