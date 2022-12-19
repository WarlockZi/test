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
		$product = self::getProduct('slug', $slug)->toArray();
		$product['parentCategories'] = self::getParentCategories($product['category']);
		return $product;
	}

	protected static function flatten_array(array $demo_array) {
		$new_array = array();
		array_walk_recursive($demo_array, function($array) use (&$new_array) { $new_array[] = $array; });
		return $new_array;
	}

	protected static function getParentCategories($categories)
	{
		$categoriesArr = [];
		$categoriesArr[] = $categories;
		while (isset($categories['category_recursive'])) {
			if (isset($categories['category_recursive']['name'])) {
				$categoriesArr[] = $categories['category_recursive'];
			}
			$categories=$categories['category_recursive'];
		}
		return array_reverse($categoriesArr);
	}

	public static function getEdit($id)
	{
		return self::getProduct('id', $id);
	}

	protected static function getProduct(string $where, $val)
	{
		return Product::
		with('category.properties.vals')
			->with('category.category_recursive','category.parents')
			->with('detailImages')
			->with('smallPackImages')
			->with('bigPackImages')
			->with('mainImage')
			->with('mainUnit')
			->with('secondaryUnit')
//			->with('cat')
//			->with('categories')
//			->with('parents')
			->where($where, $val)->first();
	}



}