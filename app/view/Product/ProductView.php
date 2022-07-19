<?php
namespace app\view\Product;

use app\model\Category;

class ProductView
{

	public function __construct()
	{

	}

	public static function belongToCategory(Category $category)
	{

		$arr = $category->toArray();

		$str = '';
		foreach ($arr['products'] as	$product){

			$str.="<div>{$product['name']}</div>";
		}
		return $str;

	}

}
