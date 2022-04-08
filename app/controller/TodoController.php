<?php

namespace app\controller;

use app\model\Todo;
use app\model\User;
use app\view\View;
use app\view\components\CustomList\CustomList;


class TodoController Extends AppController
{
	protected $model = Todo::class;
	protected $modelName = 'todo';
	protected $tableName = 'todos';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
	}
	public function index()
	{
		$daily = Todo::findAllWhere('type', 'daily');
		$daily = getTable($daily);

	}

	public function actionList()
	{
//		$this->view = 'list';
		$user_id = $this->user['id'];
		$items = $this->model::findAllWhere(['type'=>'daily','user_id'=>$user_id]);
		$daily = $this->getTable($items)->html;
		$this->set(compact('daily'));

//		$items = $this->model::findAllWhereOrCreate('type','weekly');
		$weekly = '';
		$this->set(compact('weekly'));
//
//		$items = $this->model::findAllWhereOrCreate('type','yearly');
		$yearly = '';
		$this->set(compact('yearly'));
	}

	private function getTable($items)
	{
		return new CustomList(
			[
				'models' => $items,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
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
					'post_id' => [
						'className' => 'post_id',
						'field' => 'post_id',
						'name' => 'Должность',
						'width' => '1fr',
						'contenteditable'=>'contenteditable',
						'data-type'=>'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
//				'delCol' => false,
				'delCol' => 'ajax',
				'addButton'=> 'ajax',//'redirect'
			]
		);
	}

	public function actionShow()
	{
		$todos=Todo::findAll();
		$table = $this->getTable($todos);
		$this->set(compact('table'));
	}


	public function actionCreate()
	{
		if ($this->ajax) {
			$this->ajax['user_id'] = $this->user['id'];
			$this->ajax['post_id'] = $this->user['post_id'];
			$post=52;
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
		}
	}


	public function actionDelete()
	{
		$id = $this->ajax['id']??$_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWith("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}


	public function actionUpdate()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			$this->exitWith('ok' );
		}
		$this->layout = 'admin';
		$this->view = 'edit_update';

	}
}
