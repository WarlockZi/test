<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\Product\ProductView;


class ProductController extends AppController
{

  public $model = Product::class;

  public function actionEdit()
  {
    $id = $this->route['id'];
    $prod = ProductRepository::getProduct('id', $id);
    $product = $breadcrumbs = null;
    if ($prod) {
      $product = ProductView::edit($prod);
      $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, false, true);
    }
    $this->set(compact('product', 'breadcrumbs'));
  }

//	protected function detachTagFromImage($tagName, $imgId)
//	{
//		$tag = Tag::first('name', $tagName);
//		$image = Image::find($imgId);
//		$image->tags()->detach($tag->id);
//	}
//
//	public function actionAddDescription()
//	{
//		if ($this->ajax) {
//			$product= Product::find($this->ajax['id']);
//			$product->dtxt = $this->ajax['description'];
//			$product->save();
//			$this->exitWithPopup('ok');
//		}
//	}
//
//	public function actionSetProperty()
//	{
//		if ($this->ajax) {
//			$this->ajax['propertable_type'] = Product::class;
//			$id = Propertable::create($this->ajax);
//
//			$this->exitWithPopup('hurra');
//		}
//	}
//
//	public function actionList()
//	{
//		$items = Product::all()->take(10);
//		$list = ProductView::list($items);
//		$this->set(compact('list'));
//	}

//	public function actionIndex()
//	{
//		$this->view='card';
//		if (isset($this->route['slug'])) {
//			$slug = $this->route['slug'];
//			$product = ProductCardView::getCard($slug);
//			$this->set(compact('product'));
//		}
//	}

}
