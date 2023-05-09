<?php

namespace app\view\Product;

use app\core\FS;
use app\model\Product;
use app\Repository\ImageRepository;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\Image\ImageView;
use Engine\DI\DI;

class ProductView
{
	protected $model = 'product';
	protected static $mainImagePath = '/pic/product/uploads/';

	public static function pagination($str = ''): string
	{
		$count = Product::count();
		$remnant = $count % 10;
		$full = ($count - $remnant) / 10;
		for ($i = 1; $i < $full; $i++) {
			$str .= "<div data-pagination='{$i}'>$i</div>";
		}
		return "<div data-model='product' class = 'pagination'>{$str}</div>";
	}

	public static function toCart(Product $p){
		return FS::getFileContent(__DIR__.'/toCart.php', compact('p'));
	}

	public static function mainImage(Product $p)
	{
		$dnd = DndBuilder::make('product/uploads', 'add-file');
		$img = ImageRepository::getProductMainImage($p);
		return "<div class='dnd-container'>{$dnd}{$img}</div>";
	}

	public static function getMainImageFile(Product $product): string
	{
		return FS::platformSlashes(ROOT . self::$mainImagePath . "{$product->art}.jpg");
	}

	public static function getMainImage(Product $product): string
	{
		$file = ProductView::getMainImageFile($product);
		if (is_readable($file)) {
			return FS::getFileContent(__DIR__ . '/main_image.php', compact('product'));
		} else {

			return ImageView::noImage();
//			$path = self::$mainImagePath . $product->art . '.jpg';
//			$file = FS::platformSlashes(ROOT . $path);
//			if (is_file($file)) {
//				return "<img src='$path' loading='lazy'>";
//			}
//			return '';
		}
	}
//	public static function getCardMainImage(Product $product): string
//	{
//		$file = ProductView::getMainImageFile($product);
//		if (is_readable($file)) {
//			return FS::getFileContent(__DIR__ . '/main_image.php', compact('product'));
//		} else {
//
//			return ImageView::noImage();
////			$path = self::$mainImagePath . $product->art . '.jpg';
////			$file = FS::platformSlashes(ROOT . $path);
////			if (is_file($file)) {
////				return "<img src='$path' loading='lazy'>";
////			}
////			return '';
//		}
//	}
	public static function getCardMainImage($product)
	{
		$file = FS::platformSlashes(ProductView::getMainImageFile($product));
		if (is_readable($file)) {
			return FS::getFileContent(__DIR__ . '/main_image.php', compact('product'));
		} else {
			return ImageView::noImage();
		}
	}

}
