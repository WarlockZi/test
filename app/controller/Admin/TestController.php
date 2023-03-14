<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Router;
use app\Factory\AbstractTestFactory;
use app\model\Test;
use app\view\Test\TestView;
use app\view\View;


class TestController extends AppController
{
	public $model = Test::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionDo(): void
	{
		$id = $this->route->id;
		$test = AbstractTestFactory::getFactory('test')->do($this->route->id);
		$this->set(compact('test'));
	}


	public function actionEdit()
	{
		$id = Router::getRoute()->id;
		$test = Test::query()->find($id);

		if ($test) {
			$item = TestView::item($test);
			$this->set(compact('item'));

		} else {
			$test = '';
			$this->set(compact('test'));
		}
	}

	public function actionIndex()
	{
		View::setMeta('Система тестирования', 'Система тестирования', 'Система тестирования');
	}

	public function actionPathshow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$page_name = 'Создание папки';
		$this->set(compact('page_name'));

		$paths = $this->paths();
		$this->set(compact('paths'));

		$test['isTest'] = 0;
		$rootTests = Test::where('isTest', 0)->get()->toArray();
		$this->set(compact('rootTests', 'test'));
	}

	public function actionGetCorrectAnswers()
	{
		$this->exitJson(($_SESSION['correct_answers']));
	}


	public function actionPaths()
	{
		exit(json_encode($this->paths()));
	}

	private function paths()
	{
		return Test::where('isTest', '0')->get()->toArray();
	}

	public function actionTests()
	{
		$this->exitJson(Test::where('isTest', '1')->get()->toArray());
	}


}
