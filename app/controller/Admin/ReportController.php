<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Product;
use app\Repository\ProductRepository;
use app\view\Product\ProductFormView;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;

class ReportController extends AppController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function actionProductswithoutimgInstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::hasNoImgInStore();
		$productList = ProductFormView::hasNoImgList($p, 'Товары без картинок в наличии');
		$this->set(compact('productList'));
	}

	public function actionProductswithoutimgNotinstore()
	{
		$this->view = 'productswithoutimg';
		$p = ProductRepository::hasNoImgNotInStore();
		$productList = ProductFormView::hasNoImgList($p, 'Товары без картинок без наличия');
		$this->set(compact('productList'));
	}

	public function actionProductsnominimumunit()
	{
		$this->view = 'productswithoutimg';
//		$u = Unit::has('mainUnits',function($q){
////			$q->query()->wherePivot('main',1);
//		})->get()
//			->toArray()
//		;
//		$u = Unit::has('units'
////			,function($q){
//////			$q->query()->wherePivot('main',1);
////		}
//		)->with('units')
//			->get()
////			->pluck('units.pivot.product_id')
//			->toArray();
//		$u = Unit::whereHas('mainUnits',function($q){
//			$q->where('main',1);
//		})->get()->toArray();
//		$products = Product::whereHas('baseUnit', function ($q) {
//			$q->whereHasMorph(
//				'units',
//				[User::class],
//				function ($qu) {
//					$qu->wherePivot('main', 1);
//				});
//		})->with('baseUnit.units')
//			->get();
		$products = DB::table('unitables')
			->orderBy('product_id')
			->get()
			->groupBy('product_id')
			->filter(function ($i) {
				$o = $i->filter(function ($v) {
					return $v->main;
				});
				if (!$o->count()) return $i;
			});
		$arr = new Collection();
		foreach ($products as $id => $product) {
			$prod = Product::where('1s_id', $id)->first();
			if ($prod)
				$arr->push($prod);
		}
		$products = Collection::make($arr);
		$productList = ProductFormView::hasNoImgList($products, 'Товары без min упаковки');
		$this->set(compact('productList'));
	}

	public function actionProductshaveonlybaseunit()
	{
		$p = ProductRepository::haveOnlyBaseUnit();
//		var_dump($p);
		$productList = ProductFormView::hasOnlyBaseUnit($p);
		$this->set(compact('productList'));
	}
}


