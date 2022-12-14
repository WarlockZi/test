<?php

namespace app\controller;

use app\model\IlluminateModelDecorator;
use app\model\Image;
use app\model\Product;
use app\model\Propertable;
use app\model\Tag;
use app\Repository\ImageRepository;
use app\Repository\ProductRepository;
use app\view\Category\CategoryView;
use app\view\Product\ProductCardView;
use app\view\Product\ProductView;


class ProductController Extends AppController
{

	public function actionEdit()
	{
		$id = $this->route['id'];
		$prod = ProductRepository::getEdit($id);

		$product = ProductView::edit($prod);
		$breadcrumbs = CategoryView::breadcrumbs($prod->category->id, true);
		$this->set(compact('product', 'breadcrumbs'));
	}

	public function actionIndex()
	{
		$this->view='card';
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$product = ProductCardView::getCard($slug);
			$this->set(compact('product'));
		}
	}


///................ DEL IMAGE
	public function actionDelMainImage()
	{
		if ($this->ajax) {
			$product = Product::find($this->ajax['productId']);
			$product->main_img = null;
			$product->save();
			$this->exitWithPopup('ok');
		}
	}

	protected function detachTagFromImage($tagName, $imgId)
	{
		$tag = Tag::first('name', $tagName);
		$image = Image::find($imgId);
		$image->tags()->detach($tag->id);
	}

	public function actionDelDetailImage()
	{
		if ($this->ajax) {
			$imgId = $this->ajax['id'];
			$product = Product::find($this->ajax['productId']);
			$this->detachTagFromImage('Детальная картинка товара', $imgId);
			$this->exitWithPopup('ok');
		}
	}
	public function actionDelSmallPackImage()
	{
		if ($this->ajax) {
			$imgId = $this->ajax['id'];
			$product = Product::find($this->ajax['productId']);
			$this->detachTagFromImage('Внутритарная упаковка', $imgId);
			$this->exitWithPopup('ok');
		}
	}

	public function actionDelBigPackImage()
	{
		if ($this->ajax) {
			$imgId = $this->ajax['id'];
			$this->detachTagFromImage('Транспортная упаковка', $imgId);
			$this->exitWithPopup('ok');
		}
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

	protected function addImage(string $tagName)
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

	public function actionAddDetailImages()
	{
//		ProductRepository::clear();
		$this->addImage('Детальная картинка товара');
	}

	public function actionAddSmallPackImage()
	{
//		ProductRepository::clear();
		$this->addImage('Внутритарная упаковка');
	}

	public function actionAddBigPackImage()
	{
//		ProductRepository::clear();
		$this->addImage('Транспортная упаковка');
	}

	public function actionAddDescription()
	{
		if ($this->ajax) {
			$product= Product::find($this->ajax['id']);
			$product->dtxt = $this->ajax['description'];
			$product->save();
			$this->exitWithPopup('ok');
		}
	}

	public function actionUpdateOrCreate()
	{
		IlluminateModelDecorator::updateOrCreate(Product::class, $this->ajax);
	}

	public function actionSetProperty()
	{
		if ($this->ajax) {
			$this->ajax['propertable_type'] = Product::class;
			$id = Propertable::create($this->ajax);

			$this->exitWithPopup('hurra');
		}
	}

	public function actionList()
	{
		$items = Product::all()->take(10);
		$list = ProductView::list($items->toArray());
		$this->set(compact('list'));

	}


}
