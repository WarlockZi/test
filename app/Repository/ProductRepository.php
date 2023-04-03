<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Product;
use app\model\Property;
use app\model\Val;
use app\view\Image\ImageView;

class ProductRepository extends Controller
{
	public static $ProductRepository;

	public static function preparePropertiesList(Product $product)
	{
		$arr = [
			['name' => 'Артикул', 'value' => $product->art],
			['name' => 'Страна', 'value' => $product->manufacturer->country->name ?? 'Неизвестен'],
			['name' => 'Производитель', 'value' => $product->manufacturer->name ?? 'Неизвестен'],
		];

		foreach ($product->values as $value) {
			$property = Val::find($value->id)->property->name;
			array_push($arr, ['name' => $property, 'value' => $value->name]);
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
		return $item->price;
	}

	public static function imageStatic($column, $item, $d)
	{
//		$src = ImageRepository::getImagePath($item);
		$art = trim($item->art);
		$src = "/pic/product/uploads/{$art}.jpg";
		if (is_file(ROOT . $src)) {
			return "<img style='width: 50px; height: 50px;' src='{$src}'>";
		}else{
			return ImageView::noImage();
		}
	}

	public static function getCard($slug)
	{
		$product = self::edit('slug', $slug);
		return $product;
	}

	public static function edit(int $val)
	{
		return Product::
		with('category.properties.vals')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('mainImages')
			->with('values')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')
			->with('baseUnit')
			->with('mainUnit')
//			->with('parentCategoryRecursive')
			->find($val);
	}

	public static function main(string $slug)
	{
		return Product::query()
			->with('category.properties.vals')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('price')
			->with('mainImages')
			->with('values')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')
			->with('baseUnit')
			->with('mainUnit')
//			->with('parentCategoryRecursive')
			->where('slug', $slug)
			->first();
	}

}