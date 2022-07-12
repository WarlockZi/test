<?php

namespace app\controller;


use app\model\Category;
use app\model\Model;
use app\view\View;
use app\view\widgets\Accordion\Accordion;

class CategoryController Extends AppController
{

	private $model = 'category';
	private $table = 'categories';

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
		$categories = Category::findAll();

		$accordion = new Accordion([
			'models' => $categories,
			'model' => new Category(),
			'parentFieldName' => 'category_id',
//			'link'=>'adminsc/category/update',
		]);

		$this->set(compact('categories'));
		$this->set(compact('accordion'));
	}

	public function actionEdit()
	{
		$id = $this->route['id'];
		$category = Category::findOneModel($id);
//			$categry['parent'] = $categry->parent();
//			$categry['products'] = $categry->products();
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
