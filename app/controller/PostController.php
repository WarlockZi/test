<?php

namespace app\controller;

use app\model\Post;
use app\model\User;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomList\CustomList;
use app\view\components\CustomSelect\CustomSelect;
use app\view\components\CustomMultiSelect\CustomMultiSelect;
use app\view\View;


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

	private function getItem($item, $chiefs, $subordinates,$subordinates1)
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
					'cheif' => [
						'className' => 'cheif',
						'field' => 'cheif',
						'name' => 'Подчиняется',
						'width' => '1fr',
						'contenteditable' => false,
						'data-type' => 'select',
						'select' => $chiefs,
					],
					'subourdinate' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'select',
						'select' => $subordinates,
					],
					'subourdinate1' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'multiselect',
						'select' => $subordinates1,
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
		$id = $this->route['id'];
		$chiefs = $this->getSelectCheifs(Post::cheifs($id));
//		$this->set(compact('chiefs'));
		$subordinates = $this->getSelectSubordinate(Post::subordinates($id));

		$subordinates1 = $this->getMultiselectSubordinate(Post::subordinates($id));


		$post = $this->model::findOneWhere('id', $id);
		$item = $this->getItem($post,$chiefs,$subordinates,$subordinates1)->html;
		$this->set(compact('item'));

		$this->view = 'edit';

	}

	private function getSelectCheifs($array)
	{
		return CustomSelect::run([
			'field'=> 'cheif',
			'tab'=> '.',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
		]);
	}
	private function getSelectSubordinate($array)
	{
		return CustomSelect::run([
			'field'=> 'subordinate',
			'tab'=> '.',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
		]);
	}

	private function getMultiselectSubordinate($array)
	{
		return CustomMultiSelect::run([
			'field'=> 'subordinate',
			'tab'=> '.',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
		]);
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
			if (User::can($this->user, 'post_update')) {
				$this->model::update($this->ajax);
				$this->exitWith('ok');
			}
		}
	}

}
