<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Product;
use app\model\Property;
use app\model\Val;

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

		foreach ($product->values as $value){
			$property = Val::find($value->id)->property->name;
			array_push($arr, ['name'=>$property, 'value'=>$value->name]);
		}
		return $arr;
	}

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
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
			->with('category.parentRecursive', 'category.parents')
			->with('mainImages')
			->with('values')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')
			->with('baseUnit')
			->with('mainUnit')
			->with('parentCategoryRecursive')
			->find($val);
	}

}