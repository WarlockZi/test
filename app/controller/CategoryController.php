<?php

namespace app\controller;


use app\model\Product;
use app\view\components\Tree\Tree;
use app\model\Category;

use app\view\View;


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
		$category = Category::findOneModel($id);
		$category = $category->fields ;
		$cat = Category::where('id','=',$id)
			->with('product')
			->get();
		$products = $cat->hasMany[Product::class]['items'];
//			$categry['parent'] = $categry->parent();
//			$categry['products'] = $categry->products();
		$this->set(compact('category'));
		$this->set(compact('cat'));
		$this->set(compact('products'));
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
