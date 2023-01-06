<?php


namespace app\Repository;


use app\model\Category;
use app\model\Product;

class BreadcrumbsRepository
{

	public static function breadcrumbs(int $id,
																		 bool $lastIsALink = false,
																		 bool $admin = true,
																		 string $class = 'breadcrumbs-1'): string
	{
		$prefix = $admin ? '/adminsc' : '';

		$parents = Category::with('parentRecursive')
			->find($id);

		$arr = [];
		$finalCategory = self::getLastCategory($lastIsALink, $parents);
		while ($parents->parent_recursive) {
			$id = $parents->parent_recursive->id;
			$slug = $prefix ? "/edit/{$id}" : "/{$parents->parent_recursive->slug}";
			$name = $parents->parent_recursive->name;
			array_push($arr,
				"<li><a href={$prefix}/category{$slug}>{$name}</a></li>");
			$parents = $parents->parent_recursive;
		}
		$initCategory = self::getInitCategory(true, 'Категории', "{$prefix}/category");
		array_push($arr, $initCategory);
		$arr = array_reverse($arr);
		array_push($arr, $finalCategory);
//		$breadcrumbs = implode('&nbsp;>&nbsp;', $arr);
		$breadcrumbs = implode('', $arr);
		return "<nav class='{$class}'>{$breadcrumbs}</nav>";
	}

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


	protected static function getLastCategory(bool $isLink, $parents): string
	{
		return $isLink
			? "<li><a href='/adminsc/category/edit/{$parents['id']}'>{$parents['name']}</a></li>"
			: "<li><div>{$parents['name']}</div></li>";
	}

	protected static function getInitCategory(bool $isLink, $title, $href): string
	{
		return $isLink
			? "<li><a href='{$href}'>{$title}</a></li>"
			: "<li><div>{$title}</div></li>";
	}


}