<?php


namespace app\controller;


use app\model\Illuminate\Tag;
use app\view\Tag\TagView;

class TagController extends AppController
{

	public $model = Tag::class;

	public function actionIndex()
	{
		$tags = Tag::all();
		$tags = TagView::list($tags);
		$this->set(compact('tags'));
	}

}