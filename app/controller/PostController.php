<?php

namespace app\controller;

use app\model\Post;
use app\model\User;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\View;
use app\view\components\CustomList\CustomList;


class PostController Extends AppController
{
	protected $model = Post::class;
	protected $modelName = 'post';
	protected $tableName = 'posts';

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
		$this->view = 'list';

		$items = $this->model::findAll();
		if (!$items) {
			$id = Post::create();
			$items = $this->model::findAll();
		}

		$table = $this->getTable($items)->html;
		$this->set(compact('table'));
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
						'data-type' => 'number',
						'sort' => true,
						'search' => false,
					],

					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'full_name' => [
						'className' => 'fullname',
						'field' => 'full_name',
						'name' => 'Полное наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
				],

				'editCol' => true,
//				'delCol' => false,
				'delCol' => 'ajax',
				'addButton' => 'ajax',//'redirect'
			]
		);
	}

	private function getItem($item)
	{
		return new CustomCatalogItem(
			[
				'item' => $item,
				'modelName' => $this->modelName,
				'tableClassName' => $this->tableName,
				'fields' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'contenteditable' => '',
						'width' => '50px',
						'data-type' => 'number',
					],
					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
					'full_name' => [
						'className' => 'fullname',
						'field' => 'full_name',
						'name' => 'Полное наименование',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
					],
				],

				'delBttn' => 'ajax',
				'toListBttn' => true,
				'saveBttn' => 'ajax',//'redirect'
			]
		);
	}

	public function actionEdit()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			$this->exitWith('ok');
		}

		$post = $this->model::findOneWhere('id',$this->route['id']);
		$item = $this->getItem($post)->html;
		$this->set(compact('item'));

		$this->view = 'edit';

	}

	public function actionCreate()
	{
		if ($this->ajax) {
			if ($id = $this->model::create($this->ajax)) {
				exit(json_encode([
					'id' => $id,
				]));
			}
		}
	}

	public function actionDelete()
	{
		$id = $this->ajax['id'] ?? $_POST['id'];
		if (User::can($this->user, 'right_delete') || defined(SU)) {
			if ($this->model::delete($id)) {
				$this->exitWith("ok");
			}
		}
		header('Location:/adminsc/right/list');
	}

	public function actionShow()
	{
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			if (User::can($this->user,'post_update')){
				$this->model::update($this->ajax);
				$this->exitWith('ok');

			}
		}

	}
//	public function actionUpdate()
//	{
//		if ($this->ajax) {
//			$updated = $this->model::update($this->ajax);
//			$this->exitWith('updated');
//		}
//
//		$this->view = 'update';
//
//	}
}
