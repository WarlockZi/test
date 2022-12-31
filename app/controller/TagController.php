<?php


namespace app\controller;


use app\model\Tag;
use app\view\Tag\TagView;

class TagController extends AppController
{

	public $model = Tag::class;

	public function actionIndex()
	{
		$tags = TagView::list(Tag::class);
		$this->set(compact('tags'));
	}

}