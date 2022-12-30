<?php

namespace app\controller;


use app\model\Category;
use app\view\Accordion\AccordionBuilder;
use app\view\Category\CountryView;
use app\view\components\MyTree\Tree;


class CategoryController Extends AppController
{

	public $model = \app\model\Category::class;
	public $modelName = 'category';

	public function __construct(array $route)
	{
		parent::__construct($route);
	}

	public function actionIndex()
	{
		$accordion = '';
		if (isset($this->route['slug'])) {
			$this->view = 'category';
			$slug = $this->route['slug'];

			$category = Category::where('slug', $slug)
				->with('childrenRecursive')
				->with('parentRecursive')
				->with('products')
				->with('products.mainImages')
				->get()->first();
			$this->set(compact('category'));

			$breadcrumbs = CountryView::breadcrumbs($category->id, false,false);
			$this->set(compact('breadcrumbs'));

		} else {

			$categories = Category::where('category_id', 0)
				->with('childrenRecursive')
				->get();
			$this->set(compact('categories'));
			$this->view = 'categories';

		}

		$this->set(compact('accordion'));

	}

	protected function adminIndex()
	{
		$categories = Category::all()->toArray();

		$accordion = Tree::build($categories)
			->parent('category_id')
			->model('category')
			->get();

		$this->set(compact('categories'));
		$this->set(compact('accordion'));

	}

//	public function actionIndex()
//	{
//		$slug = $this->route['slug'];
//
//		$categories = Category::where('slug',$slug)
//			->with('children')
//			->first()
//			->toArray();
//
//		$accordion = Tree::build($categories)
//			->parent('category_id')
//			->model('category')
//			->get();
//
//		$this->set(compact('categories'));
//		$this->set(compact('accordion'));
//	}


	public function actionEdit()
	{
		$id = $this->route['id'];
		$breadcrumbs = CountryView::breadcrumbs($id);
		$category = CountryView::edit($id);
		$this->set(compact('category', 'breadcrumbs'));
	}


	///................. ADD IMAGE
//	public function actionAddMainImage()
//	{
////		ProductRepository::clear();
//		if ($_FILES) {
//			$image = ImageRepository::saveIfNotExistReturnModel($_FILES[0], 'ctegory');
//			$product = Product::find($_POST['imageable_id']);
//			$product->main_img = $image->id;
//			$product->save();
//			$this->exitJson(['msg' => 'ok', 'id' => $image->id]);
//		}
//	}


//	public function actionUpdateOrCreate()
//	{
//		if ($this->ajax) {
//			$id = $this->modelName::updateOrCreate($this->ajax);
//			if (is_numeric($id)) {
//				$this->exitJson(['popup' => 'Сохранен', 'id' => $id]);
//			} elseif (is_bool($id)) {
//				$this->exitWithPopup('Сохранено');
//			} else {
//				$this->exitWithError('Ответ не сохранен');
//			}
//		}
//	}

//	public function actionDelete()
//	{
//		if ($this->ajax['id']) {
//			if ($this->model::delete($this->ajax['id'])) {
//				$this->exitWithPopup('Категория удаленa');
//			}
//		} else {
//			$this->exitWithMsg('No id');
//		}
//	}
//
//	public function actionSetMainImage()
//	{
//		if ($this->ajax) {
//			$this->exitWithPopup('dd');
//
//		}
//	}

}
