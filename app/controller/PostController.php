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

	private function getItem($item, $chiefs, $subordinates)
	{
		$item = new CustomCatalogItem(
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
						'data-type' => 'multiselect',
						'select' => $chiefs,
					],
					'subourdinate' => [
						'className' => 'fullname',
						'field' => '$subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'multiselect',
						'select' => $subordinates,
					],
				],

				'delBttn' => 'ajax',
				'toListBttn' => true,
				'saveBttn' => 'ajax',//'redirect'
			]
		);
		return $item->html;
	}

	public function actionEdit()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			$this->exitWith('ok');
		}

		$id = $this->route['id'];
		$post = $this->model::findOneWhere('id', $id);

		$chiefs = $this->getMultiselectCheifs(Post::findAll(), $post['chief']);
		$subordinates = $this->getMultiselectSubordinates(Post::findAll(), $post['subordinate']);

		$item = $this->getItem($post, $chiefs, $subordinates);
		$this->set(compact('item'));

		$this->view = 'edit';

	}

	private function getMultiselectCheifs($array, $selected)
	{
		return CustomMultiSelect::run([
			'className' => 'type1',
			'field' => 'cheif',
			'tab' => '.',
			'fieldName' => 'name',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
			'selected' => $selected,
		]);
	}

	private function getMultiselectSubordinates($array, $selected)
	{
		return CustomMultiSelect::run([
			'className' => 'type1',
			'field' => 'subordinate',
			'tab' => '.',
			'fieldName' => 'name',
			'initialOption' => true,
			'initialOptionValue' => '--',
			'tree' => $array,
			'selected' => $selected,
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

		if ($this->model::delete($id)) {
			$this->exitWith("ok");
		}

		header('Location:/adminsc/post/list');
	}

	public function actionShow()
	{
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
//			if (User::can($this->user, 'post_update')) {
			$this->model::updateorcreate($this->ajax);
			$this->exitWith('ok');
//			}
		}
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



//	private function getSelectCheifs($array)
//	{
//		return CustomSelect::run([
//			'className' => 'type1',
//			'field' => 'cheif',
//			'tab' => '.',
//			'fieldName' => 'name',
//			'initialOption' => true,
//			'initialOptionValue' => '--',
//			'tree' => $array,
//		]);
//	}

//	private function getSelectSubordinate($array)
//	{
//		return CustomSelect::run([
//			'className' => 'type1',
////			'title'=> 'cheif',
//			'field' => 'subordinate',
//			'fieldName' => 'name',
//			'tab' => '.',
//			'initialOption' => true,
//			'initialOptionValue' => '--',
//			'tree' => $array,
//		]);
//	}

//	private function getMultiselectSubordinate($array)
//	{
//		return CustomMultiSelect::run([
//			'field' => 'subordinate',
//			'className' => 'type1',
//			'tab' => '.',
////			'initialOption' => true,
////			'initialOptionValue' => '--',
//			'tree' => $array,
//		]);
//	}

}
