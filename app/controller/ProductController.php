<?php

namespace app\controller;

use app\model\IlluminateModelDecorator;
use app\model\Image;
use app\model\Product;
use app\model\Propertable;
use app\model\Tag;
use app\Repository\ProductRepository;
use app\view\Category\CountryView;
use app\view\Product\ProductView;
use app\view\View;


class ProductController Extends AppController
{

	public function actionEdit()
	{
		$id = $this->route['id'];
		$prod = ProductRepository::getProduct('id',$id);

		$product = ProductView::edit($prod);
		$breadcrumbs = CountryView::breadcrumbs($prod->category->id, true);
		$this->set(compact('product', 'breadcrumbs'));
	}

	public function actionIndex()
	{
		$this->view='card';
		if (isset($this->route['slug'])) {
			$slug = $this->route['slug'];
			$product = ProductRepository::getProduct('slug',$slug);
			$breadcrumbs = ProductRepository::getBreadcrumbs($product,false,);
			$this->set(compact('product'));
			$this->set(compact('breadcrumbs'));
		}
		View::setMeta(
			$product->title,
			$product->description,
			$product->keywords,);
	}


	protected function detachTagFromImage($tagName, $imgId)
	{
		$tag = Tag::first('name', $tagName);
		$image = Image::find($imgId);
		$image->tags()->detach($tag->id);
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
