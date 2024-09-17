<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\core\Response;
use app\core\Route;
use app\model\Post;
use app\view\Post\PostView;


class PostController Extends AppController
{
	public  $model = Post::class;
	public  $modelName = 'post';
	public  $tableName = 'posts';

	public function __construct()
	{
		parent::__construct();

	}

	public function actionIndex():void
	{
		$list = PostView::listAll();
		$this->set(compact('list'));
	}


	public function actionEdit()
	{
		if ($this->ajax) {
			$this->model::update($this->ajax);
			Response::exitWithPopup('ok');
		}
		$id = $this->route['id'];

		$item = PostView::item($id);
		$this->set(compact('item'));
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


	public function actionDelete():void
	{
		$id = $this->ajax['id'] ?? $_POST['id'];

		if ($this->model::delete($id)) {
			Response::exitWithPopup("ok");
		}

		header('Location:/adminsc/post/table');
	}



}
