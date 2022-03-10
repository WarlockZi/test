<?php

namespace app\controller;

use app\core\App;
use app\model\User;
use app\view\components\CustomList\CustomList;
use app\view\View;


class RightController Extends AppController
{

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
	}

	public function actionList()
	{
		$this->view = 'create';

		$rights = App::$app->right->all();
		$this->set(compact('rights'));

		$rights_table = $this->rigtsTable($rights)->html;
		$this->set(compact('rights_table'));

	}

	private function rigtsTable($rights)
	{
		return new CustomList(
			[
				'models' => $rights,
				'modelName' => "right",
				'tableClassName' => 'rights',
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type'=>'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => true,
				'delCol' => true,
			]
		);
	}

	public function actionShow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$rootTests = App::$app->test->findAllWhere('isTest', 0);
		$test['isTest'] = 1;
		$this->set(compact('rootTests', 'test'));
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
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if (App::$app->right->delete($this->ajax['id'])) {
				exit(json_encode(['msg' => 'ok']));
			}
		}

		header('Location:/adminsc/right/list');
//		App::$app->test->update($this->ajax['test']);
//		exit(json_encode(['notAdmin' => true]));
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
	}
}
