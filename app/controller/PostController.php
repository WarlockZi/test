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
	public  $model = Post::class;
	public  $modelName = 'post';
	public  $tableName = 'posts';

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

		$table = $this->getList($items);
		$this->set(compact('table'));
	}

	private function getList($items)
	{
		return include ROOT . '/app/view/Post/getList.php';
	}


	public function actionEdit()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			$this->exitWithPopup('ok');
		}

		$id = $this->route['id'];
		$post = $this->model::findOneWhere('id', $id);
		if (!$post) {
			$item = 'Элемент отсутствует';
		} else {
			$chiefs = $this->getMultiselectCheifs(Post::findAll(), $post['chief']);
			$subordinates = $this->getMultiselectSubordinates(Post::findAll(), $post['subordinate']);
			$item = $this->getItem($post, $chiefs, $subordinates);
		}
		$this->set(compact('item'));
		$this->view = 'edit';
	}

	private function getItem($item, $chiefs, $subordinates)
	{
		return include ROOT . '/app/view/Post/getItem.php';
	}

	protected function getMultiselectCheifs($array, $selected)
	{
		return include ROOT . '/app/view/Post/getMultiselectCheifs.php';
	}

	protected function getMultiselectSubordinates($array, $selected)
	{
		return include ROOT . '/app/view/Post/getMultiselectSubordinates.php';
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
			$this->exitWithPopup("ok");
		}

		header('Location:/adminsc/post/list');
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$this->model::updateorcreate($this->ajax['model']);
			$this->exitWithPopup('ok');
		}
	}

	public function actionUpdate()
	{
		if ($this->ajax) {
			if (User::can($this->user, 'post_update')) {
				$this->model::update($this->ajax);
				$this->exitWithPopup('ok');
			}
		}
	}

	public function actionShow()
	{
	}


}
