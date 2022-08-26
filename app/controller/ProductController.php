<?php

namespace app\controller;

use app\model\Illuminate\IlluminateModelDecorator;
use app\model\Illuminate\Image;
use app\model\Illuminate\Product;
use app\model\Illuminate\Propertable;
use app\Repository\ProductRepository;
use app\view\Category\CategoryView;
use app\view\Product\ProductView;


class ProductController Extends AppController
{

	public function actionEdit()
	{
		$id = $this->route['id'];
		$prod = Product::
		with('category.properties.vals')
			->with('category.category_recursive')
//			->with('category.category_recursive.properties.vals')
			->with('mainImage')
			->with('detailImages')
			->find($id);
		$product = ProductView::edit($prod);
		$breadcrumbs = CategoryView::breadcrumbs($prod->category, true);
		$this->set(compact('product', 'breadcrumbs'));
	}

	public function actionIndex()
	{
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$card = ProductView::card($slug);
			$this->set(compact('card'));
		}
	}

	public function actionDelMainImg(){
		if ($this->ajax){
			$product = Product::find($this->ajax['productId']);
			$product->main_img = null;
			$product->save();
			$this->exitWithPopup('ok');
		}
	}
	public function actionDelDetailImg(){
		if ($this->ajax){
			$imgId = $this->ajax['id'];
			$product = Product::find($this->ajax['productId']);
			$product->detailImages()->detach($imgId);
//			$product->save();
			$this->exitWithPopup('ok');
		}
	}

	public function actionImageDetail()
	{
//		ProductRepository::clear();
		if ($_FILES) {
			foreach ($_FILES as $file) {
				$image = ProductRepository::prepareImage($file);
				$product = Product::find($_POST['imageable_id']);
				$product->detailImages()->sync($image, false);
			}
			$this->exitJson(['msg' => 'ok',]);
		}
	}



	public function actionImageMain()
	{
//		ProductRepository::clear();
		if ($_FILES) {
			$image = ProductRepository::prepareImage($_FILES[0]);

			$product = Product::find($_POST['imageable_id']);
			$product->main_img = $image->id;
			$product->save();

			$this->exitJson(['msg' => 'ok',]);
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
		$list = ProductView::listAll();
		$this->set(compact('list'));

	}


}
