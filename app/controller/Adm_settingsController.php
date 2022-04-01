<?php

namespace app\controller;

use app\core\App;
use app\model\Product;
use app\view\View;
use app\controller\AdminscController;

class Adm_settingsController extends AdminscController
{

	public function __construct($route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
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
