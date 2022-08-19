<?php

namespace app\controller;


use app\model\Category as Category;
use app\model\Illuminate\Category as IlluminateCategory;
use app\view\Category\CategoryView;
use app\view\components\Tree\Tree;


class CategoryController Extends AppController
{

	private $model = 'category';
	private $modelName = \app\model\Category::class;

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$categories = IlluminateCategory::all()->toArray();

		$accordion = Tree::buildTree(
			[
				'items' => $categories,
				'model' => Category::class,
				'parent' => 'category_id',
				'template' => 'category',
			]
		);

		$this->set(compact('categories'));
		$this->set(compact('accordion'));
	}

	public function actionEdit()
	{
		$id = $this->route['id'];
		$breadcrumbs = CategoryView::breadcrumbs($id);
		$category = CategoryView::edit($id);
		$this->set(compact('category','breadcrumbs'));
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$id = $this->modelName::updateOrCreate($this->ajax);
			if (is_numeric($id)) {
				$this->exitJson(['popup' => 'Сохранен', 'id' => $id]);
			} elseif (is_bool($id)) {
				$this->exitWithPopup('Сохранено');
			} else {
				$this->exitWithError('Ответ не сохранен');
			}
		}
	}

	public function actionDelete()
	{
		if ($this->ajax['id']) {
			if ($this->model::delete($this->ajax['id'])) {
				$this->exitWithPopup('Категория удален');
			}
		} else {
			$this->exitWithMsg('No id');
		}
	}


}
