<?php

namespace app\controller;


use app\view\View;


class ValController Extends AppController
{

	private $modelName = 'val';
	private $model = '\app\model\val';
	private $table = 'vals';

	public function __construct(array $route)
	{
		parent::__construct($route);
		$this->autorize();
		$this->layout = 'admin';
		View::setCss('admin.css');
		View::setJs('admin.js');
	}

	public function actionIndex()
	{
		$categories = Category::all()->toArray();

		$accordion = new Tree([
			'items' => $categories,
			'model' => Category::class,
			'parent' => 'category_id',
			'template' => 'category',
//			'link'=>'adminsc/category/update',
		]);
		$accordion = $accordion->output();

		$this->set(compact('categories'));
		$this->set(compact('accordion'));
	}

	public function actionEdit()
	{
		$id = $this->route['id'];

		$category = Category::with('products','parent_rec')
			->where('id', '=', $id)
			->get()[0];

		$category = CategoryView::edit($category);
		$categoryList = CategoryView::list($category);


		$this->set(compact('category'));
	}

	public function actionUpdateOrCreate()
	{
		if ($this->ajax) {
			$id = $this->model::updateOrCreate($this->ajax);
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

	public function actionShow()
	{
		if ($this->ajax) {
			$a_id = $this->model::autoincrement();
			$q_id = $this->ajax['q_id'];

			$this->model::create([]);
		}

	}

}
