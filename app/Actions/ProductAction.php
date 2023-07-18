<?php


namespace app\Actions;


use app\core\FS;
use app\model\Product;
use app\Storage\StorageProduct;

class ProductAction
{
	static $imgPath = 'product/uploads/';

	public static function attachMainImage($file)
	{
		$storage = new StorageProduct();
		$path = self::getFilePaths($file,$storage);
		$f = self::saveImge($path,$storage,$file);

	}

	public static function saveImge($path,$storage,$file){
//		if (!is_file($path)) {
			return $storage->saveFile($path, $file);
//		}
		return false;
	}
	protected static function getFilePaths($file,$storage){
		$rel = $storage->getImagePath().$storage->productImagesPath . $file['name'];
		$path = FS::platformSlashes($storage->getImagePath() . $file['name']);
		$srcs['absoluteSrcs'][] = $path;
		$srcs['relativeSrcs'][] = $rel;
		return $srcs;
	}

	public static function changeVal(array $req)
	{
		$product = Product::find($req['product_id']);
		$newVal = $req['morphed']['new_id'];
		$oldVal = $req['morphed']['old_id'];

		if (!$oldVal) {
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Добавлен']));

		} else if (!$newVal) {
			$product->values()->detach($oldVal);
			exit(json_encode(['popup' => 'Удален']));

		} else {
			if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
			$product->values()->detach($oldVal);
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Поменян']));
		}
	}

	public static function changeUnit(array $req)
	{
		UnitAction::changeUnit($req);
	}

	public static function changePromotion(array $req)
	{
		UnitAction::changeUnit($req);
	}
}