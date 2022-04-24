<?php

namespace app\controller;

use app\core\App;
use app\model\Product;
use app\model\User;
use app\view\View;
use app\view\widgets\Accordion\Accordion_sidebar;

class AdminscController extends AppController
{

	public function __construct($route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
//		View::setJs('admin.js');
//		View::setCss('admin.css');
		if (User::can($this->user, ['role_employee'])) {
			View::setJs('admin.js');
			View::setCss('admin.css');
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


	public function createSiteMap() {

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

	public function actionProps()
	{
		$catProps = Product::findAll('props', "`sort`");
		foreach ($catProps as $k => $v) {
			$catProps[$k]['val'] = explode(',', $catProps[$k]['val']);
		};
		$this->vars['catProps'] = $catProps;
	}

	public function actionProp()
	{
		if (isset($_GET['id']) && $_GET['id']) {
			$id = $_GET['id'];
		}
		$prop = Prop::findOneWhere('id', $id);
		$prop['val'] = $prop['val'] ? explode(',', $prop['val']) : [];
		$this->vars['prop'] = $prop;
	}

}


