<?php

namespace app\view\Category;

use app\core\Auth;
use app\core\FS;
use app\model\Category;
use app\model\Product;
use app\Repository\ImageRepository;
use app\view\Image\ImageView;

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
			$relativePath = ImageRepository::getProductMainImageSrc($product);
			return FS::getFileContent(__DIR__ . '/product_main_image.php', compact('relativePath', 'product'));
	}

	public static function getMainImage(Category $category)
	{
		if ($category->mainImages->count()) {
			ImageView::catMainImage($category->mainImages->first());
		} else {
			return ImageView::noImage();
		}
	}
}