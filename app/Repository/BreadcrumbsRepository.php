<?php


namespace app\Repository;


use app\model\Category;
use app\model\Product;

class BreadcrumbsRepository
{

  private static function getPrefix(bool $admin):string
  {
    return 	$admin ? '/adminsc/category/' : '/category/';
  }

	private static function flatCategoryParents(Category $category): array
	{
		$cats[] = $category;
		if ($category->parentRecursive) {
			while ($category->parentRecursive) {
				array_push($cats, $category->parentRecursive);
				$category = $category->parentRecursive;
			}
		}
		return $cats;
	}

	public static function getProductBreadcrumbs(Product $product,
																								bool $linkLast = false,
																								bool $admin = false,
																								string $class = 'breadcrumbs-4'){
	  if ($product->category){
	    return self::getCategoryBreadcrumbs($product->category, $linkLast, $admin, $class);
    }
    $prefix = self::getPrefix($admin);

    $str = "<li><a href='{$prefix}'>Категории</a></li>";
    return "<nav class='{$class}'>{$str}</nav>";
  }

	public static function getCategoryBreadcrumbs(int $id,
																								bool $linkLast = false,
																								bool $admin = false,
																								string $class = 'breadcrumbs-4')
	{
		$str = '';
		$prefix = self::getPrefix($admin);
		$category = Category::with('parentRecursive')->find($id);

		$arrayCategories = self::flatCategoryParents($category);

		foreach ($arrayCategories as $i => $cat) {
			$slug = $admin ? "edit/{$cat->id}" : "{$cat->slug}";
			if ($i === 0) {
				if (!$linkLast) {
					$str = "<li><div>{$cat->name}</div></li>" . $str;
				} else {
					$str = "<li><a href='{$prefix}{$slug}'>{$cat->name}</a></li>" . $str;
				}
			} else {
				$str = "<li><a href='{$prefix}{$slug}'>{$cat->name}</a></li>" . $str;
			}
		}

		$str = "<li><a href='{$prefix}'>Категории</a></li>" . $str;
		return "<nav class='{$class}'>{$str}</nav>";

	}
}