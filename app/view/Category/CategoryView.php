<?php

namespace app\view\Category;

use app\core\Auth;
use app\core\FS;
use app\model\Category;
use app\model\Product;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;
use app\view\Product\ProductView;

class CategoryView
{

	public static function getProductCard(Product $product, $icon): string
	{
		$admin = Auth::isAdmin();
		$srt = FS::getFileContent(__DIR__ . '/product_card.php', compact('product', 'admin', 'icon'));
		return $srt;
	}

	public static function getProductMainImage(Product $product)
	{
		$file = ProductView::getMainImageFile($product);
		if (is_readable($file)) {
			$relativePath = ImageRepository::getProductMainImageSrc($product);
			$srt = FS::getFileContent(__DIR__ . '/product_main_image.php', compact('relativePath', 'product'));
			return $srt;
		} else {
			return ImageView::noImage();
		}
	}

	public static function getMainImage(Category $category)
	{
		if ($category->mainImages->count()) {
			ImageView::catMainImage($category->mainImages->first());
		} else {
			return ImageView::noImage();
		}
	}

//	public static function selector(int $selected, int $exclude = -1): string
//	{
//		$cats = Category::all()->toArray();
//		$parent_select = '<select>';
//		$parent_select .= "<option value=0>---</option>";
//		foreach ($cats as $t) {
//			if ((int)$t['id'] !== $exclude) {
//				$selectedStr = (int)$t['id'] === $selected ? 'selected' : '';
//				$parent_select .= "<option value={$t['id']} {$selectedStr}>{$t['name']}</option>";
//			}
//		}
//		$parent_select .= "</select>";
//
//		return $parent_select;
//	}

}