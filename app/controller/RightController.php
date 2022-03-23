<?php

namespace app\controller;

use app\core\App;
use app\model\Right;
use app\model\Test;
use app\model\User;
use app\view\View;
use app\view\components\CustomList\CustomList;


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

		$rights = Right::findAll();
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
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
					'description' => [
						'className' => 'description',
						'field' => 'description',
						'name' => 'Описание',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
				'delCol' => 'ajax',
				'addButton'=> 'ajax',//'redirect'
			]
		);
	}

	public function actionShow()
	{
		$this->layout = 'admin';
		$this->view = 'edit_show';
		$rootTests = Test::findAllWhere('isTest', 0);
		$test['isTest'] = 1;
		$this->set(compact('rootTests', 'test'));
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = App::$app->right->create($this->ajax)) {
//				$q_id = App::$app->question->create();
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
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if (App::$app->right->delete()) {
				$this->exitWith('ok');
			}
		}
//		$this->exitWith('no right_delete');
		header('Location:/adminsc/right/list');

	}


	public function actionUpdate()
	{
		if ($this->ajax) {
			$updated = Right::update($this->ajax);
			$this->exitWith('updated' );

		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

		$id = $this->route['id'];
		$test =Test::findOneWhere('id',$id);
		$test['children'] = Test::findAllWhere('parent',$id);

		$rootTests = Test::findAllWhere('isTest', 0);
//		$rootTestsTree = $this->hierachy($rootTests, 'parent');
		$this->set(compact('rootTests', 'test'));
	}
}
