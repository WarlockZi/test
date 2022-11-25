<?php

namespace app\controller;



use app\model\Illuminate\Category;
use app\model\Illuminate\Product;
use app\model\Illuminate\Tag;
use app\Repository\ImageRepository;
use app\view\Category\CategoryView;
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
		$categories = Category::all()->toArray();

		$accordion = Tree::build($categories)
			->parent('category_id')
			->model('category')
			->get();

		$this->set(compact('categories'));
		$this->set(compact('accordion'));
	}

	public function actionEdit()
	{
		$id = $this->route['id'];
		$breadcrumbs = CategoryView::breadcrumbs($id);
		$category = CategoryView::edit($id);
		$this->set(compact('category', 'breadcrumbs'));
	}


	///................. ADD IMAGE
	public function actionAddMainImage()
	{
//		ProductRepository::clear();
		if ($_FILES) {
			$image = ImageRepository::saveIfNotExistReturnModel($_FILES[0]);
			$product = Product::find($_POST['imageable_id']);
			$product->main_img = $image->id;
			$product->save();
			$this->exitJson(['msg' => 'ok', 'id' => $image->id]);
		}
	}

	protected function actionAddImage(string $tagName)
	{
		if ($_FILES) {
			foreach ($_FILES as $file) {
				$image = ImageRepository::saveIfNotExistReturnModel($file);
				$product = Product::find($_POST['imageable_id']);
				$tag = Tag::where('name', $tagName)->first();
				$images = $product->detailImages;
				if (!$images->contains($image))
					$product->detailImages()->sync($image, false);
				if (!$image->tags->contains($tag)) {
					$image->tags()->sync($tag, false);
					$this->exitJson(['msg' => 'ok', 'id' => $image->id]);
				} else {
					$this->exitJson(['popup' => 'уже есть такая картинка', 'id' => 0]);
				}
			}
		}
	}
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

	public function actionSetMainImage()
	{
		if ($this->ajax) {
			$this->exitWithPopup('dd');

		}
	}

}
