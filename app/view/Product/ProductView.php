<?php

namespace app\view\Product;

use app\core\FS;
use app\model\Product;
use app\Repository\ImageRepository;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\Image\ImageView;

class ProductView
{
	protected $model = 'product';
	protected static $mainImagePath = '/pic/product/uploads/';
	protected static $viewPath = ROOT.'/app/view/Product/Admin/';

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

	public static function mainImage(Product $p)
	{
		$dnd = DndBuilder::make('product/uploads', 'add-file');
		$img = ImageRepository::getProductMainImage($p);
		return "<div class='dnd-container'>{$dnd}{$img}</div>";
	}

	public static function baseEqualsMainUnit(Product $p)
	{
		return FS::getFileContent(self::$viewPath.'baseEqualsMain.php',[$p]);
	}
	public static function mainImageSrc(Product $p)
	{
		$src = '/pic/product/uploads/' . $p->art . '.jpg';
		$slashedSrc = FS::platformSlashes(ROOT . $src);
		if (is_readable($slashedSrc)) {
			return $src;
		}
		return ImageView::noImageSrc();
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
		}
	}

	public static function getCardMainImage($product)
	{
		$file = FS::platformSlashes(ProductView::getMainImageFile($product));
		if (is_readable($file)) {
			$image =  FS::getFileContent(__DIR__ . '/main_image.php', compact('product'));
		} else {
			$image = ImageView::noImage();
		}
		return "<div class='main-image'>{$image}</div>";
	}

}
