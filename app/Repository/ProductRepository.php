<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Product;

class ProductRepository extends Controller
{
	public static $ProductRepository;

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
	}

	public static function getCard($slug)
	{
		$product = self::getProduct('slug', $slug);
		return $product;
	}

	public static function getProduct(string $where, $val)
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
			->with('mainUnit')
			->with('secondaryUnit')
			->with('parentCategoryRecursive')
			->where($where, $val)->first();
	}

}