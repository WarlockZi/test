<?php


namespace app\Repository;


use app\model\Category;

class BreadcrumbsRepository
{

	private static function arrayCategories(Category $category): array
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

	public static function getCategoryBreadcrumbs(Category $category,
																								bool $linkLast = false,
																								bool $admn = false,
																								string $class = 'breadcrumbs-1')
	{
		$str = '';
		$prefix = $admn ? '/adminsc/category/' : '/category/';

		$arrayCategories = self::arrayCategories($category);

		foreach ($arrayCategories as $i => $cat) {
			$slug = $admn ? "edit/{$cat->id}" : "{$cat->slug}";
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