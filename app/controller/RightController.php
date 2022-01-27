<?php

namespace app\controller;

use app\view\View;
use app\view\widgets\menu\Menu;
use app\core\App;
use app\model\User;

use app\view\widgets\Tree\Tree;


class RightController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
	}


	public function actionShow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$rootTests = App::$app->test->findAllWhere('isTest', 0);
		$test['isTest'] = 1;
		$this->set(compact('rootTests', 'test'));
		View::setCss('test_edit.css');
		View::setJs('test_edit.js');
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = App::$app->right->create($this->ajax)) {
				$q_id = App::$app->question->create();
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {

			if ($id = App::$app->test->updateOrCreate($this->ajax['id'], $this->ajax)) {
				$q_id = App::$app->question->create();
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}



	public function actionDelete()
	{
		if (User::can($this->user, 4) || SU) {
			if (App::$app->right->delete($this->ajax['id'])) {
				exit(json_encode(['msg' => 'ok']));
			}
		}
		App::$app->test->update($this->ajax['test']);
		exit(json_encode(['notAdmin' => true]));
	}


	public function actionUpdate()
	{
		if ($this->ajax) {
			$updated = App::$app->right->update($this->ajax);
			exit(json_encode(['updated' => $updated]));
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

		$id = $this->route['id'];
		$test = App::$app->test->findOne($id);
		$test['children'] = App::$app->test->getChildren($id);

		$rootTests = App::$app->test->findAllWhere('isTest', 0);
//		$rootTestsTree = $this->hierachy($rootTests, 'parent');
		$this->set(compact('rootTests', 'test'));

		View::setCss('admin.css');
		View::setJs('admin.js');
	}

}
