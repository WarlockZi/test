<?php


namespace app\Repository;


use app\controller\Controller;
use app\core\FS;
use app\model\Product;
use app\model\Unit;
use app\model\Val;
use app\Storage\StorageImg;
use app\view\Image\ImageView;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends Controller
{

	public static function edit(int $id)
	{
		$id = Product::where('id', $id)->first()['1s_id'];
		return Product::query()
			->where('1s_id', $id)
			->with('category.properties.vals')
			->with('values')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('mainImages')
			->with('manufacturer.country')
			->with('detailImages')
			->with('promotions')
			->with('smallpackImages')
			->with('bigpackImages')
			->with(['baseUnit' => function ($query) use ($id) {
				$query->with(['units' => function ($query) use ($id) {
						$query->wherePivot('product_id', $id)->get();
					}]
				);
			}])
			->first();
	}

	public static function main(string $slug)
	{
		$p = Product::where('slug', $slug)->first();
		$id = Product::where('slug', $slug)->first()['1s_id'];
		return Product::query()
			->orderBy('sort')
			->with('category.properties.vals')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('price')
			->with('mainImages')
			->with('values.property')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')
			->with('promotions.unit')
			->with('seo')
			->with(['baseUnit' => function ($query) use ($id) {
				$query->with(['units' => function ($query) use ($id) {
						$query->wherePivot('product_id', $id)->get();
					}]
				);
			}])
			->where('slug', $slug)
			->first();
	}

	public static function noMinimumUnit()
	{
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
			$prod = Product::where('1s_id', $id)->get()->first();
			if ($prod && $prod->instore)
				$arr->push($prod);
		}
		return Collection::make($arr);
	}

	public static function haveOnlyBaseUnit()
	{


//				$baseUnit = DB::table('units')
//			->select(DB::raw(1))
//			->whereColumn('unitables.unit_id', 'units.id');
//
//		$mainUnit = DB::table('unitables')
//			->select(DB::raw(1))
//			->whereColumn('unitables.unit_id', 'units.id');

//		$products = DB::table('products')
//			->select('*')
//			->whereExists(function ($q) {
//				$q->select()
//					->from('units')
//					->whereColumn('products.base_unit', 'units.id')
//					->whereDoesnExist(function ($query) {
//						$query->select()
//							->from('unitables')
//							->selectRaw('unitable_type= \app\model\Unit and unitable_id=units.id');
//					});
//			})
//			->toSql()//			->get()
//		;

		$products = Product::query()
			->whereHas('baseUnit', function ($q) {
				$q->whereDoesntHave('units');
			})
//			->toSql()
						->get(['id', 'art', 'name'])
		;
//		$products = DB::select("select `id`, `art`, `name` from `products` where exists (select * from `units` where `products`.`base_unit` = `units`.`id` and not exists (select * from `units` as `u` inner join `unitables` on `u`.`id` = `unitables`.`unitable_id` where `units`.`id` = `unitables`.`unit_id` and `unitables`.`unitable_type` = 'app\model\Unit'))");
		var_dump($products);
		return $products;

	}

	protected static function getP($products)
	{
		foreach ($products as $k => $product)
			return $product;
	}

	public static function list()
	{
		return Product::query()
			->with('price')
			->take(20)
			->orderBy('sort')
			->get();
	}

	public static function hasNoImgInStore()
	{
		$products = Product::query()
			->select('art', 'name', 'id', 'instore')
			->get();

		$arr = new Collection();
		foreach ($products as $product) {
			$file = StorageImg::getFile('product/uploads/' . $product->art . '.jpg');
			if (!is_file($file) && $product->instore) {
				$arr->push($product);
			}
		}
		return $arr;
	}

	public static function hasNoImgNotInStore()
	{
		$products = Product::query()
			->select('art', 'name', 'id', 'instore')
			->get();

		$arr = new Collection();
		foreach ($products as $product) {
			$file = StorageImg::getFile('product/uploads/' . $product->art . '.jpg');
			if (!is_file($file) && !$product->instore) {
				$arr->push($product);
			}
		}
		return $arr;
	}

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
	}

	public static function priceStatic($column, $item, $d)
	{
		return $item->getRelation('price')->price ?? 0;
	}

	public static function imageStatic($column, $item, $d)
	{
		$art = trim($item->art);
		$src = "/pic/product/uploads/{$art}.jpg";
		if (is_file(ROOT . $src)) {
			return "<img style='width: 50px; height: 50px;' src='{$src}'>";
		} else {
			return ImageView::noImage();
		}
	}

	public static function getFilters()
	{
		$self = new static();
		$filters = [
			'instore' => 'Показать с остатком = 0',
			'price' => 'Показать c ценой = 0',
		];
		return FS::getFileContent($self->viewPath . 'filters.php', compact('filters'));
	}
}