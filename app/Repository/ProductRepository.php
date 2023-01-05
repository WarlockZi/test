<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Product;

class ProductRepository extends Controller
{
	public static $ProductRepository;

	public static function getBreadcrumbs(Product $product,
																				bool $linkLast = false,
																				bool $admn = false,
																				string $class = 'breadcrumbs-1'
	)
	{
		$cats = [];
		$cats[] = $product->parentCategoryRecursive;
		$cat[0] = $product->parentCategoryRecursive;
		while ($cat[0]->parentRecursive) {
			array_push($cats, $cat[0]->parentRecursive);
			$cat[0] = $cat[0]->parentRecursive;
		}

		$str = '';
		$prefix = $admn ? '/admin' : '/category/';
		if (!$linkLast){
			$lastLink = array_splice($cats, 0,1);
			$str = "<li><div>{$lastLink[0]->name}</div></li>";
		}

		foreach ($cats as $ind => $cat) {

			$slug = $admn ? "edit/{$cat->id}" : "{$cat->slug}";
			$str = "<li><a href='{$prefix}{$slug}'>{$cat->name}</a></li>" . $str;
		}

		$str = "<li><a href='/category'>Категории</a></li>" . $str;
		return "<nav class='{$class}'>{$str}</nav>";
	}

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