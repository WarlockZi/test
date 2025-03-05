<?php


namespace app\controller\Admin;


use app\controller\AppController;
use app\model\Tag;
use app\view\Tag\TagView;

class TagController extends AdminscController
{

	public string $model = Tag::class;

	public function actionIndex():void
	{
		$tags = TagView::list(Tag::class);
		$this->setVars(compact('tags'));
	}

}