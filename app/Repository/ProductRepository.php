<?php


namespace app\Repository;


use app\controller\Controller;
use app\core\FS;
use app\model\Product;
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
			->with('properties')
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
		$id = $p['1s_id'];
		$product = Product::query()
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

//		$product->mainImage = (new ProductMainImage($product))->getRelativePath();
		return $product;
	}

	public static function noMinimumUnit()
	{
		$unitables = DB::table('unitables')
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

		foreach ($unitables as $id => $unitable) {
			$prod = Product::where('1s_id', $id)
				->with('properties')
				->get()->first();

			if ($prod) {
				if ($prod->instore) {
					if ($prod->properties) {
						if (!$prod->properties->base_equals_main_unit)
							$arr->push($prod);
					} else {
						$arr->push($prod);
					}
				}
			}
		}
		return Collection::make($arr);
	}

	public static function haveOnlyBaseUnit()
	{
		$all = DB::select("select * from `products` where instore > 0 and not exists (select * from `unitables` as `b` where `b`.`product_id` = `products`.`1s_id`)");
		return $all;
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

	public static function hasMainImage(Product $p){
		return $p->mainImagePath == '/pic/srvc/nophoto-min.jpg';
	}

	public static function hasNoImgInStore()
	{
		$products = Product::query()
			->select('art', 'name', 'id', 'instore')
			->where('instore', '>', 0)
			->get();

		$arr = new Collection();
		foreach ($products as $product) {
			if (self::hasMainImage($product)) {
				$arr->push($product);
			}
		}
		return $arr;
	}

	public static function hasNoImgNotInStore()
	{
		$products = Product::query()
			->select('art', 'name', 'id', 'instore')
			->where('instore', '<', 0)
			->get();

		$arr = new Collection();
		foreach ($products as $product) {
//			$file = StorageImg::getFile('product/uploads/' . $product->art . '.jpg');
			if (self::hasMainImage($product)) {
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