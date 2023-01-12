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
//		$product['parentCategories'] = self::getParentCategories($product['category']);

		return $product;
	}

	protected static function flatten_array(array $demo_array)
	{
		$new_array = array();
		array_walk_recursive($demo_array, function ($array) use (&$new_array) {
			$new_array[] = $array;
		});
		return $new_array;
	}

	protected static function getParentCategories($categories)
	{
		$categoriesArr = [];
		$categoriesArr[] = $categories;
		while (isset($categories['parentRecursive'])) {
			if (isset($categories['parentRecursive']['name'])) {
				$categoriesArr[] = $categories['parentRecursive'];
			}
			$categories = $categories['parentRecursive'];
		}
		return array_reverse($categoriesArr);
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