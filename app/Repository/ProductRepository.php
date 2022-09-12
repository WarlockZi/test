<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Illuminate\Product;

class ProductRepository extends Controller
{

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
	}

	public static function getCard($slug)
	{
		return self::getProduct('slug', $slug)->toArray();
	}

	public static function getEdit($id){

		return self::getProduct('id', $id);
	}

	protected static function getProduct(string $where, $val){
		return Product::
		with('category.properties.vals')
			->with('category.category_recursive')
			->with('detailImages')
			->with('smallPackImages')
			->with('bigPackImages')
			->with('mainImage')
			->with('mainUnit')
			->with('secondaryUnit')
			->where($where, $val)->get();
	}

}